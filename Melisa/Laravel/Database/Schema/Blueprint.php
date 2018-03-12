<?php

namespace Melisa\Laravel\Database\Schema;

use Illuminate\Database\Schema\Blueprint as ParentBlueprint;
use Illuminate\Support\Facades\DB;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Blueprint extends ParentBlueprint
{
    
    /**
     * Add creation and update timestamps with defaults to the table.
     *
     * @return void
     */
    public function timestamps($precision = 0)
    {
        $this->dateTime('createdAt')->default(DB::raw('CURRENT_TIMESTAMP'));
        $this->dateTime('updatedAt')->nullable();
    }
    
    /**
     * Add creation and update timestamps with defaults to the table.
     *
     * @return void
     */
    public function active($default = 1)
    {
        $this->boolean('active')->default($default);
    }
    
    
    /**
     * Add creation and update timestamps with defaults to the table.
     *
     * @return void
     */
    public function identity()
    {
        $this->uuid('idIdentityCreated');
        $this->uuid('idIdentityUpdated')->nullable();
    }
    
}
