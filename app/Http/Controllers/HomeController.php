<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Collection;

use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function proses(Request $request)
    {
                $fileName = 'input'.'.'.$request->file->getClientOriginalExtension();

        $request->file->move(public_path(), $fileName);
         $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template_rekap.xlsx');
        
         $spreadSheet = new Spreadsheet();
          $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('input.csv');


          $cellValue = $spreadsheet->getActiveSheet()->getCell('A1')->getValue();
          $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

          $cellValue2 = $spreadsheet->getActiveSheet()->getCell('A'.$highestRow)->getValue();

          $a=[];
   
          $collection = new Collection();
    
          for ($i=2; $i < $highestRow+1 ; $i++) { 
              $nama = $spreadsheet->getActiveSheet()->getCell('A'.$i)->getValue();
              
              $time = $spreadsheet->getActiveSheet()->getCell('F'.$i)->getValue();
             
              $time_fix = substr($time, 2, -4);
              $jam_md = substr($time, 13, -4);
               $jam =substr($time, 13, -10 ) ;
              $md = substr($time, 15, -7);

               $convert_jam = (int)$jam+8;
           
               if ($convert_jam == 24) {
                   $convert_jam = 0;
               }
               if ($convert_jam > 24) {
                  
                   $convert_jam = $convert_jam - 24;
               }
               $convert_full = $convert_jam . $md;
                
                //  $a[$i-2]=['nama'=>$nama, 'datang'=>$convert_full, 'pulang'=>''];
            //    $collection->offsetSet('nama', $nama);
            //    $collection->offsetSet('hadir', $convert_full);
            $collection->push((object)['nama'=>$nama, 'datang'=>$convert_full, 'pulang'=>'']);

              
          }
        //   dd($a->firstWhere('nama', 'Imam Satya Wedhatama'));
           $collection2 = new Collection();
        //    dd(count($collection));
           for ($i=0 ; $i <  count($collection); $i++ ) { 
            //    dd();
               $a = $collection->where('nama', $collection[$i]->nama)->values();
            //    dd(count($a));
               if (count($a)>=2) {
                //    dd($a[count($a)-1]);
                //    dd($a[count($a)-1]);
                $a[0]->pulang = $a[count($a)-1]->datang;
                // dd($a[0]);
               }
                $collection2->push((object)['nama'=> $a[0]->nama, 'datang'=> $a[0]->datang, 'pulang'=> $a[0]->pulang]);
           }
             $unique = $collection2->unique()->values();
     
        //    dd($unique[3]->nama);

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template_rekap.xlsx');
            
            $worksheet = $spreadsheet->getActiveSheet();
            
             $spreadsheet->getActiveSheet()->insertNewRowBefore( 5 ,count($unique));
            $batas=count($unique)+4;
            

            for ($i=4; $i < $batas ; $i++) {        
                //  $spreadsheet->getActiveSheet()->insertNewRowBefore(13+$i, 1);
               
                 $worksheet->getCell('A'.$i)->setValue($i-3);
 
               
                $worksheet->getCell('B'.$i)->setValue($unique[$i-4]->nama);//uraian kegiatan
                 $worksheet->getCell('C'.$i)->setValue($unique[$i-4]->datang);//uraian kegiatan
                 $worksheet->getCell('D'.$i)->setValue($unique[$i-4]->pulang);//uraian kegiatan           
               
            }
                // dd($unique);
           $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
           
          $writer->save('write.xlsx');
              

        // return response()->json(['success'=>'You have successfully upload file.']);
        
    }
     public function download_excel(){
           
           
             $file="./write.xlsx";
        return Response::download($file, 'SehatSehatSemuanya'.'.xlsx') ;
       }
}
