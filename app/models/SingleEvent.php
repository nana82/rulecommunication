<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SingleEvent
 *
 * @author Naveed
 */
class Event extends Eloquent{
    
    protected $guarded = array();
    
    public function Dispatches() {
        return $this->belongsTo('dispatches', 'dispatch_id');
    }
}

