<?php namespace Melisa\Laravel\Database;

use Illuminate\Database\Seeder;
use Melisa\Laravel\Database\Seeds\Json\ImportSimple;
use Melisa\Laravel\Database\Seeds\Csv\ImportSimple as CsvImportSimple;
use Melisa\Laravel\Database\Seeds\Txt\ImportSimple as TxtImportSimple;
use Melisa\Laravel\Database\Seeds\Module\InstallJson;

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
        CleanLogsSeeder,
        ImportSimple,
        CsvImportSimple,
        TxtImportSimple,
        InstallJson;
    
    public function run() {
        
    }
    
}
