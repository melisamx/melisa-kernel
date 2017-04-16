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
    
    public function installAssetImage($find, $values) {
        
        $values ['idAssetType']= 4;
        
        return $this->installAsset($find, $values);
                
    }
    
    public function installAsset($find, $values) {
        
        if( !isset($values['version'])) {
            $application = $this->findApplication(config('app.keyapp'));
            if($application) {
                $values ['version']= $application->version;
            }
        }
        
        return $this->updateOrCreate('App\Core\Models\Assets', [
            'find'=>[
                'id'=>$find
            ],
            'values'=>$values
        ]);
        
    }
    
}
