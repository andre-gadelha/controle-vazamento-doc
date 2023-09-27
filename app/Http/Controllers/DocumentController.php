<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Requests\DocumentFormRequest;
use Carbon\Traits\Options;
use DB;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Document;


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
        
        $hashIdentidade = md5($request->input(key:'identidade'));//Gera e armazena o hash MD5 da idntidade informada 
        $nameFile = $request->file(key:'document')->getClientOriginalName(); //Armazena nome do arquivo
        $documentPath = $request->file(key:'document')->storeAs(path:'pdf', name:"$nameFile", options:'public');//Armazena o patth do arquivo 
        $autorDoControle = $request->input(key: 'autor');
        $receptorDoDocumento = $request->input(key: 'nome');
        $funcaoDoReceptor = $request->input(key: 'funcao');
        $identidadeDoReceptor = $request->input(key: 'identidade');  
        //dd($);


        $request->documentPath = $documentPath;//adicionando a variável $documentPath ao Request(servirá para recuperação da variavel no Request utilizado ao persistir no banco de dados)

        // Source file and watermark config 
        $file = storage_path('app/public/'. $documentPath .''); 
        
        //ADICIONAR NO BANCO DE DADOS
        //$document = new Document();//Objeto que pode ser utilizado em caso da utilização do ELOQUENT ORM
        DB::insert(query:'INSERT INTO documents 
            (authorControlDocument,         nameReceiverDocument,           funcntionReceiverDocument,      identityReceiverDocument,           nameDocument,         rashDocument) 
            values 
            ("' . $autorDoControle . '",    "' . $receptorDoDocumento . '", "' . $funcaoDoReceptor . '",    "' . $identidadeDoReceptor . '",    "' . $nameFile . '",  "' . $hashIdentidade . '")');
        //DB::insert(query:'INSERT INTO documents (authorControlDocument, nameReceiverDocument, funcntionReceiverDocument, identityReceiverDocument, nameDocument, rashDocument) values (?,?,?,?,?,?)', [$nameFile, $nameFile, $nameFile, $nameFile, $nameFile, $nameFile] );

        $text = $hashIdentidade;
        $path_image = '';  

        // Set source PDF file 
        $pdf = new Fpdi(); 
        
        $pagecount = $pdf->setSourceFile($file); 
        
        // Text font settings 
        $pdf->SetFont('helvetica','I', 10); 
        $pdf->SetTextColor(248,215,218);//Texto vermelho transparente
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
            $pdf->Text(150, 10, $text);

            //Segunda Linha
            $pdf->Text(10, 50, $text);
            $pdf->Text(80, 50, $text);
            $pdf->Text(150, 50, $text);

            //Terceira Linha
            $pdf->Text(10, 90, $text);
            $pdf->Text(80, 90, $text);
            $pdf->Text(150, 90, $text);

            //Quarta Linha
            $pdf->Text(10, 130, $text);
            $pdf->Text(80, 130, $text);
            $pdf->Text(150, 130, $text);

            //Quinta Linha
            $pdf->Text(10, 170, $text);
            $pdf->Text(80, 170, $text);
            $pdf->Text(150, 170, $text);

            //Sexta Linha
            $pdf->Text(10, 210, $text);
            $pdf->Text(80, 210, $text);
            $pdf->Text(150, 210, $text);
            
            //Sétima Linha
            $pdf->Text(10, 250, $text);
            $pdf->Text(80, 250, $text);
            $pdf->Text(150, 250, $text);

            //Oitava Linha
            $pdf->Text(10, 290, $text);
            $pdf->Text(80, 290, $text);
            $pdf->Text(150, 290, $text);

        } 
        
        // Output PDF with watermark 
        $pdf->Output('D', 'document.pdf');

        return redirect(to: '/document');
    }
    
}
