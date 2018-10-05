<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Item;
use App\Family;

class updateItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:updateItems {--m|max=} {--p|page=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download item data from SOAP service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      // Obtain the SOAP client
      $wsdl = __DIR__ . '/../../../public/api.wsdl';
      $this->info('Using wsdl at ' . $wsdl);
      $client = new \nusoap_client(
        $wsdl,
        'wsdl'
      );
      $err = $client->getError();

      if ($err) {
        $this->error($err);
        $this->error($client->getDebug());
        return;
      }

      $max = $this->option('max');
      $page = $this->option('page');

      $allCodes = Item::select('code')->get()->pluck('code');

      if ($page) {
        $allCodes = $allCodes->forPage($page, 20);
      }

      if ($max) {
        $allCodes = $allCodes->take($max);
      }

      function normalize($value) {
        $noEntities = preg_replace("/&#?[a-z0-9]{2,8};/i","",$value);
        $wasUpper = strtoupper($noEntities) === $noEntities;

        $value = utf8_encode($value); // From ISO-8859-1 to UTF-8
        $decoded = html_entity_decode($value, ENT_HTML5, 'UTF-8');
        if ($wasUpper) {
          $decoded = mb_strtoupper($decoded, 'UTF-8');
        }

        // Trim including &nbsp;
        $decoded = preg_replace('/^\s+|\s+$/u','',$decoded);

        return $decoded;
      }

      $data = collect();

      $bar = $this->output->createProgressBar($allCodes->count());
      foreach ($allCodes as $code) {

        $error = false;

        do {

        $result = $client->call('fichaTecnica', ['codigo' => $code]);

        if ($client->fault) {
          $msg = 'Fault (Expect - The request contains an invalid SOAP body)';
          $this->error($msg);
          $this->error($result);
          return;
        }

        $err = $client->getError();

        if ($err) {
          $this->error($err);
          $this->error($result);
          $error = true;
          continue;
        }

        $raw = $result['fichaTecnicaResult']['Ficha'];

        $res = [];
        $res['code'] = $code;
        // $res['father'] = $raw['Father'];
        $famRes = Family::where('name', normalize($raw['Familia']))->get();
        if ($famRes->count() > 0) {
          $res['family_code'] = $famRes->first()->code;
        } else {
          $res['family_code'] = null;
          $this->error('Family not found, looking for ' . $raw['Familia']);
        }
        $res['name'] = $raw['Producto'];
        $res['description_1'] = $raw['Des1'];
        $res['description_2'] = $raw['Des2'];
        $res['color'] = $raw['Color'];
        $res['capacity'] = $raw['Capacidad'];
        $res['material'] = $raw['Material'];
        $res['size'] = $raw['Size'];
        $res['qty_packing'] = $raw['Empaque'];
        $res['weight'] = $raw['Weight'];
        $res['height'] = $raw['Height'];
        $res['width'] = $raw['Width'];
        $res['length'] = $raw['Length'];
        $res['volume'] = $raw['Volumen'];
        $res['print_technique'] = $raw['TecnicaImp'];
        $res['print_area'] = $raw['AreaImp'];

        $res = collect($res);

        $res->transform(function ($value, $key) {
          // $orgvalue = $value;
          $value = normalize($value);

          $numericKeys = collect([
            'qty_packing',
            'weight',
            'height',
            'width',
            'length',
            'volume',
          ]);

          if ($numericKeys->contains($key)) {
            $value = (string) floatval($value);
          }

          // Uncomment for debugging the transformation
          // if ($value !== $orgvalue) {
          //   $this->line('');
          //   $this->info('Cambiando ' . $orgvalue . ' por ' . $value);
          //   $this->info($key);
          // }
          return $value;
        });

        $data->push($res);
        $bar->advance();
        $error = false;

      } while ($error);

      }


      $this->line('');
      $prevItems = Item::all();
      $diffs = [];

      foreach ($data as $item) {
        $prevItem = $prevItems->where('code', $item->get('code'));

        if ($prevItem->count() > 0) {
          $prevItem = $prevItem->first();

          $diff = $item->diffAssoc($prevItem);
          $diff->code = $prevItem->code;

          if ($diff->keys()->count() > 0) {

            $this->info('Diferencias para item '. $prevItem->code);
            $this->line($diff->toJson(JSON_PRETTY_PRINT));

            $this->info('Antes era: ');
            $before = collect($prevItem->only($diff->keys()->toArray()));
            $this->line($before->toJson(JSON_PRETTY_PRINT));
            $this->line('');

            $diffs[] = $diff;

          } else {
            $this->info('Item ' . $prevItem->code . ' no ha cambiado.');
          }

        } else {
          $this->error('Item con codigo desconocido');
          $this->error('Esto no debería ser posible');
        }
      }

      $diffs = collect($diffs);

      $this->line('');
      $this->info('Se encontraron ' . $diffs->count() . ' items diferentes.');
      if ($diffs->count() > 0) {
        if ($this->confirm('¿Guardar estos cambios?')) {
          foreach ($diffs as $diff) {
            $item = Item::where('code', $diff->code)->get()->first();
            foreach ($diff as $key => $val) {
              $item->{$key} = $val;
            }

            $item->save();
          }
        }
      }
    }
}
