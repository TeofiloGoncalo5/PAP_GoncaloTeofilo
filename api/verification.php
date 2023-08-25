<?php

    // Função para verificar se a variavel esta vazia ou não
    function isEmpty($var_to_verify) {
        if (empty(trim($var_to_verify))) { // Verifica se a variavel esta vazia ou não, o trim retira os espaços, isto para que o user não coloque so um espaço
            return true;
        } else {
            return false;
        }
    }
?>