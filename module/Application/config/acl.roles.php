<?php

return array(
        "visitante" => array(
                "allow" => array(
                        "ejemplo"
                ),
                "deny" => array(
                        "application/default",
                        "application",
                        "home",
                        "prueba",
                ),
        ),
        "admin" => array(
                "allow" => array(
                        "application/default",
                        "application",
                        "home",
                        "prueba",
                        "ejemplo"
                ),
                "deny" => array(),
        ),
);