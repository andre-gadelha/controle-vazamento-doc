<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Requests\DocumentFormRequest;
use Carbon\Traits\Options;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Codedge\Fpdf\Fpdf\Fpdf;


class DocumentController extends Controller
{
    protected $fpdf;
 
    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index() 
    {
        //Direcionar para a Views
        return view('upload');
    }

    public function create() 
    {
        //Usando FPDF para criação de um novo arquivo de PDF
    	$this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage("L", ['100', '100']);
        $this->fpdf->Text(10, 10, "Hello World, SEF!");       
         
        $this->fpdf->Output();

        exit;
    }

    public function store(DocumentFormRequest $request){

        //Usando FPDI para adicionar Marca d'água em arquivo PDF

        //dd($request->file(key:'document'));
        $nameFile = $request->file(key:'document')->getClientOriginalName(); //Armazena nome do arquivo
        $documentPath = $request->file(key:'document')->storeAs(path:'pdf', name:"$nameFile", options:'public');//Armazena o patth do arquivo 

        $request->documentPath = $documentPath;//adicionando a variável $documentPath ao Request(servirá para recuperação da variavel no Request utilizado ao persistir no banco de dados)

        // Source file and watermark config 
        $file = storage_path('app/public/'. $documentPath .''); 
        
        $text = 'sef.eb.mil.br';
        $path_image = '';  

        // Set source PDF file 
        $pdf = new Fpdi(); 
        
        $pagecount = $pdf->setSourceFile($file); 
        
        // Text font settings 
        $pdf->SetFont('helvetica','I', 20); 
        $pdf->SetTextColor(205,100,60);//Texto vermelho
        $ts = explode("\n", $text); 
        $width = 0; 
        
        foreach($ts as $k=>$string){ 
            $width = max($width, strlen($string)); 
        } 
             
        // Add watermark to PDF pages 
        for($i=1;$i<=$pagecount;$i++){ 
            $tpl = $pdf->importPage($i); 
            $size = $pdf->getTemplateSize($tpl); 
            $pdf->addPage(); 
            $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
            
            //Put the watermark 
            $xxx_final = ($size['width']-50); 
            $yyy_final = ($size['height']-25); 
            
            //Add Image
            //$pdf->Image($path_image, $xxx_final, $yyy_final, 0, 0, 'png');
            
            //Add Text
            //Primeira Linha
            $pdf->Text(10, 10, $text);
            $pdf->Text(80, 10, $text);
            $pdf->Text(160, 10, $text);

            //Segunda Linha
            $pdf->Text(01, 60, $text);
            $pdf->Text(80, 60, $text);
            $pdf->Text(160, 60, $text);

            //Terceira Linha
            $pdf->Text(10, 110, $text);
            $pdf->Text(80, 110, $text);
            $pdf->Text(160, 110, $text);

            //Quarta Linha
            $pdf->Text(01, 160, $text);
            $pdf->Text(80, 160, $text);
            $pdf->Text(160, 160, $text);

            //Quinta Linha
            $pdf->Text(10, 210, $text);
            $pdf->Text(80, 210, $text);
            $pdf->Text(160, 210, $text);

            //Sexta Linha
            $pdf->Text(01, 260, $text);
            $pdf->Text(80, 260, $text);
            $pdf->Text(160, 260, $text);    
        } 
        
        // Output PDF with watermark 
        $pdf->Output();
    }
    
    /*
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);
    
        $fileName = time().'.'.$request->file->extension();  
     
        $request->file->move(public_path('uploads'), $fileName);
   
         
           // Write Code Here for
            //Store $fileName name in DATABASE from HERE 
        
     
        return back()
            ->with('success','You have successfully upload file.')
            ->with('file', $fileName);
   
    }
    */

}
