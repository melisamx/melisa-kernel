<?php namespace Melisa\Laravel\Database;

use Illuminate\Database\Seeder;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class InstallSeeder extends Seeder
{
    use InstallApplication, 
        InstallAsset, 
        InstallEvent, 
        InstallModule, 
        InstallOption,
        InstallMenu,
        InstallMenuOptions,
        UpdateOrCreate,
        InstallProfile,
        IdSeeder,
        InstallRedirect,
        InstallIdentity,
        InstallTraslationLanguage,
        InstallUser,
        InstallTraslation,
        InstallApplicationRoles,
        InstallScope,
        InstallApplicationRS,
        InstallTask,
        InstallApplicationRST,
        Factory,
        InstallGateSystem,
        CleanLogsSeeder;
    
    public function run() {
        
    }
    
}
