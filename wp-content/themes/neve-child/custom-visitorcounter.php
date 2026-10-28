<?php
// El total se calcula durante init, antes de que WordPress envíe el HTML.
$visitorSessionCount = isset( $GLOBALS['banco_actual_visitor_count'] )
	? $GLOBALS['banco_actual_visitor_count']
	: false;
?>
<section>
    <div class="visitorcounter-cta">
        <div class="visitorcounter-cta-inner">
            <?php if ( $visitorSessionCount !== false ) : ?>
                <h3 class="visitorcounter-cta-title">
                    ¡Qué bueno tenerte aquí! Ya hemos recibido
                    <?php echo esc_html( (string) $visitorSessionCount ); ?>
                    <?php echo $visitorSessionCount === 1 ? 'visita' : 'visitas'; ?>.
                </h3>
            <?php else : ?>
                <h3 class="visitorcounter-cta-title">Banco Metropolitano, su banco en la capital.</h3>
            <?php endif; ?>

            <div class="visitorcounter-cta-text">Conviértete en uno de nuestros clientes.</div>
        </div>
    </div>
</section>