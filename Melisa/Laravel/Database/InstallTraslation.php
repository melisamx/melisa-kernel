<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\Translations;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallTraslation
{
    
    public function i18n($languageId, $key, $text)
    {        
        return Translations::updateOrCreate([
            'idTranslationLanguage'=>$languageId,
            'key'=>$key
        ], [
            'text'=>$text
        ]);        
    }
    
    public function i18nFind($key, $languageKey = 'es')
    {        
        return TranslationsLanguages::where([
            'key'=>$key,
            'idTranslationLanguage'=>$languageKey
        ])->firstOrFail();        
    }
    
}
