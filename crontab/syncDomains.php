<?
// Dette script skal k�re engang hvert 10. minut.

// Scriptet skal tjekke alle hoteller igennem for �ndringer i domain tabellen

// Der synkroniseres f�rst fra hotel til sitemanager,
// Der kan ikke oprettes nye dom�ner p� de enkelte hoteller, kun aliaser.
// F�r et alias bliver synkroniseret tjekkes der for om hoved dom�net er knyttet til hotellet.
// Ved synkronisering skal "pid" fra dom�ne tabellen ogs� med over i sitemgr.

// Herefter skal der synkroniseres fra sitemgr til hotel - her er der ingen regler.
// Dem s�rger typo3 nemlig selv for via backend styringen af oprettelsen.

// Sker det at samme subdom�ne skulle blive oprettede b�de backend p� typo3 og i sitemgr vil PID for den oprettede i typo3 bliver f�rt over i sitemgr.
// Og resten af data taget fra sitemgr. 

