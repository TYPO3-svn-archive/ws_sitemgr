<?
// Dette script skal k¿re engang hvert 10. minut.

// Scriptet skal tjekke alle hoteller igennem for ¾ndringer i domain tabellen

// Der synkroniseres f¿rst fra hotel til sitemanager,
// Der kan ikke oprettes nye dom¾ner pŒ de enkelte hoteller, kun aliaser.
// F¿r et alias bliver synkroniseret tjekkes der for om hoved dom¾net er knyttet til hotellet.
// Ved synkronisering skal "pid" fra dom¾ne tabellen ogsŒ med over i sitemgr.

// Herefter skal der synkroniseres fra sitemgr til hotel - her er der ingen regler.
// Dem s¿rger typo3 nemlig selv for via backend styringen af oprettelsen.

// Sker det at samme subdom¾ne skulle blive oprettede bŒde backend pŒ typo3 og i sitemgr vil PID for den oprettede i typo3 bliver f¿rt over i sitemgr.
// Og resten af data taget fra sitemgr. 

