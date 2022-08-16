;;
;; This file contains DNS reverse lookup records for customers VLAN interfaces
;;
;; WARNING: this file is automatically generated using the
;; api/v4/dns/arpa API call to IXP Manager. Any local changes made to
;; this script will be lost.
;;
;; VLAN id: <?= $t->vlan->id ?>; tag: <?= $t->vlan->number ?>; name: <?= $t->vlan->name ?>.
;;
;; Generated: <?= now()->format( 'Y-m-d H:i:s' ) . "\n" ?>
;;

$TTL 86400

@               IN      SOA     ns0.example.com.     hostmaster.example.com. (

                        <?= time() ?>      ; Serial
                        43200           ; Refresh
                        7200            ; Retry
                        1209600         ; Expire
                        7200            ; Minimum
            )

        IN      NS      ns0.example.com.
        IN      NS      ns1.example.com.

<?php foreach( $t->arpa as $a ): ?>
<?= trim($a['arpa']) ?>    IN      PTR     <?= trim($a['hostname']) ?>.
<?php endforeach; ?>

;; END
