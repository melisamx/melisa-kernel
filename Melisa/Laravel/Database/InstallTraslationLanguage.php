<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\TranslationsLanguages;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallTraslationLanguage
{
    
    public function installTranslationLanguage($id, $values)
    {        
        return TranslationsLanguages::updateOrCreate([
            'id'=>$id
        ], $values);        
    }
    
    public function findTranslationLanguage($id)
    {        
        return TranslationsLanguages::where('id', $id)->firstOrFail();        
    }
    
}
