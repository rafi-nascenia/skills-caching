<?php

apc_store('nascenia', 'foobar');

var_dump(apc_fetch('nascenia'));
