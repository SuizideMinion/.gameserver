<?php

function has_Tech($tech, $id, $level) {
    if ( isset(session('UserBuildings')[$id]) ) {
        // Check ob in Bau
        if (session('UserBuildings')[$id]->value == 1) {
            $return['imBau'] = (session('UserBuildings')[$id]->value == 1 ? 'true' : null);
            $return['errors'][] = 'Ist im bau';
        }

        // Check ob schon Gebaut
        if (session('UserBuildings')[$id]->value == 2
            and
            session('UserBuildings')[$id]->level == $level) {
            $return['Gebaut'] = 'true';
            $return['errors'][] = 'Gebaut';
        }

        // Check ob es maxlevel ist
        if (session('Buildings')[$id]->getData->pluck('value', 'key')['1.max_level']
            ==
            session('UserBuildings')[$id]->level) {
            $return['Ausgebaut'] = 'true';
            $return['errors'][] = 'Max bau';
        }
    }
}
