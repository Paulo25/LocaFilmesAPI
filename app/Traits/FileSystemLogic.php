<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileSystemLogic
{

    /**
     * Retorna tipos de extessões 
     *
     */
    public function mimeTypes()
    {

        $mimes = "ppt,pps,odp,link,pdf,epub,doc,docx,odt,swf,exe,zip,rar,swf,wmv,mpg,flv,avi,
        youtube,mp4,mp3,webm,xls,xml,ods,csv,jpg,jpeg,png,gif,txt";

        return $mimes;
    }

    /**
     * Armazena imagens na storage clientes
     */
    public function storeImage($request, $data = null)
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if (isset($data->image) && $data->image)
                Storage::disk('public')->delete("/{$data->image}");

            $extension = $request->image->extension();
            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}";

            $path = $request->image->storeAs('clientes', $nameFile);

            return $path;
        }
    }

    /**
     * Armazena arquivo pasta de guias-pedagogicos ou download ou imagem-associada
     *
     * @param $id integer
     * @param $file laravel request
     *
     * @return File
     */
    public function saveFile($id, $files, $local = null)
    {
        if ($files) {
            foreach ($files as $file) {
                $filesystem = new Filesystem;
                $rand = rand(5, 99999);
                $path = Storage::disk('conteudos-digitais')->path($local) . "/{$id}.*";
                $files = $filesystem->glob($path);
                $name = "{$id}.{$rand}.{$file->guessExtension()}";

                $file->storeAs($local, $name, 'conteudos-digitais');
            }
            return $file;
        }
    }
}
