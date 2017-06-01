<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\Tasks;
use App\Security\Models\GatesSystems;
use App\Security\Models\Gates;
use App\Security\Models\SystemsSecurity;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallGateSystem
{
    
    public function installGateSystem($gateKey, $systemKey)
    {        
        $gate = Gates::where('key', $gateKey)->firstOrFail();
        $system = SystemsSecurity::where('key', $systemKey)->firstOrFail();
        
        GatesSystems::updateOrCreate([
            'idGate'=>$gate->id,
            'idSystemSecurity'=>$system->id,
        ]);        
    }
    
}
