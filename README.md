# mactus\WEBUtils

Utility functions

## Configuração

    composer require mactus/webutils


## Uso
    
    use WEBUtils/Utils/Utils;
    echo Utils::mascara('#####-###','12345678');
    Resultado: R$ 12345-678

    use WEBUtils/Utils/UtilsDate;
    echo Utils::corrigeDataHora('2018-02-12');
    Resultado: 12/02/2018

    use WEBUtils/Utils/UtilsDecimal;
    echo Utils::formataMoedaReal('123.45', true);
    Resultado: R$ 123,45

