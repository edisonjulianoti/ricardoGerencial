<?php

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class ProdutoService
{
   
    public static function gerarBarcode($produto_id)
    {
        $produto = new Produto($produto_id);
        
        if($produto->cod_barras)
        {
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            $barcode = $generator->getBarcode($produto->cod_barras, $generator::TYPE_CODE_128, 5, 100);
            $file = "tmp/produto_barcode_{$produto_id}.png";
            file_put_contents($file, $barcode);
            
            return $file;    
        }
        
        return '';
    }
    
    public static function gerarQrCode($produto_id)
    {
        $produto = new Produto($produto_id);
        if($produto->cod_barras)
        {
            $file = "tmp/produto_qrcode_{$produto_id}.png";
            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $writer->writeFile($produto->cod_barras, $file);
            
            $imagick_image = new Imagick($file);
            $imagick_image->setCompressionQuality(100);
            $imagick_image->writeImage("png24:$file");
            
            return $file;    
        }
        return '';
    }
   
}
