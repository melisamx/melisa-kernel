<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallAsset
{
    
    public function installAssetCss($find, $values) {
        
        $values ['idAssetType']= 2;
        
        return $this->installAsset($find, $values);
        
    }    
    
    public function installAssetJs($find, $values) {
        
        $values ['idAssetType']= 1;
        
        return $this->installAsset($find, $values);
                
    }
    
    public function installAsset($find, $values) {
        
        return $this->UpdateOrCreate('App\Core\Models\Assets', [
            'find'=>[
                'id'=>$find
            ],
            'values'=>$values
        ]);
        
    }
    
}
