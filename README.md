# Referti Online

Questo progetto si propone di aiutare i pazienti e gli operatori sanitari con la gestione dei referti. 

Al momento l'Italia non ha un sistema unico per il ritiro online dei
referti e spesso gli orari di ritiro coincidono con gli orari lavorativi così costringendo i pazienti ad assentarsi dal lavoro. Dando quindi la possibilità di recuperare i referti in qualsiasi momento si libera il paziente da questa complicazione.
Non solo, il progetto si pone in grado di aiutare i medici curanti dei pazienti avendo la possibilità di consultare in autonomia i referti dei pazienti senza avere accesso all'originale fisico o ad una sua copia. 

## Requisiti del progetto

Durante l'analisi dei requisiti sono stati individuati 3 tipo di attori utenti:
- Paziente
- Operatore
- Struttura

Il Paziente deve poter:
- Consultare direttamente un referto senza essersi registrato
- Consultare un referto come utente registrato
- Scaricare il referto
- Condividere un singolo referto con un medico
- Condividere tutti i referti (presenti e futuri) con il proprio medico di fiducia

L'Operatore, che può essere l'operatore che esegue l'esame diagnostico o un medico curante/specialista, deve poter:
- Registrare l'esame svolto
- Caricare e/o modificare il referto
- Consultare i referti realizzati e/o quelli dei propri pazienti

La Struttura invece si occupa di gestire i propri operatori e deve poter:
- Aggiungere e modificare i dati dei propri operatori
- Consultare i referti realizzati dai propri operatori

## Funzioni implementate

### Paziente:
- Può registrarsi alla piattaforma inserendo Nome, Cognome, Codice Fiscale e una password (inoltre se sono presenti dei referti precedenti alla registrazione questi vengono connessi all'account automaticamente).
- Può accedere alla piattaforma inserendo il Codice Fiscale e la sua password.
- Può consultare un referto senza avere un account inserendo il codice referto e il codice d'accesso per il referto comunicato dall'operatore.
- Può dare il consenso per condividere un referto con un operatore.
- Può revocare il consenso per la condivisione di un singolo referto con un operatore.
- Può dare il consenso per condividere tutti i referti con un operatore.
- Può revocare il consenso per la condivisione di tutti i referti con un operatore.
- Può visualizzare le informazioni di un referto.
- Può scaricare i file caricati dall'operatore di un referto.

### Operatore:
- Può accedere alla piattaforma inserendo il Codice Fiscale e la sua password.
- Può creare un nuovo referto ed inserire il Codice Fiscale di un paziente (anche non registrato).
- Può caricare i file del referto sulla piattaforma.
- Può modificare il titolo e i file di un referto.
- Può visualizzare e scaricare i referti creati da lui e anche quelli condivisi dai suoi pazienti.
- Può eliminare un referto precedentemente creato.

### Struttura:
- Può registrarsi alla piattaforma inserendo Denominazione, Codice Fiscale e password.
- Può accedere alla piattaforma inserendo Codice Fiscale e password.
- Può creare un nuovo Operatore collegato inserendo Nome, Cognome, Codice Fiscale e password.
- Può modificare Nome, Cognome, Codice Fiscale e password di un suo Operatore.
- Può visualizzare i referti realizzati dai suoi Operatori.

## Documentazione del progetto:
- [Diagramma ER](doc/er.md)
- [Relazione tecnica](doc/relazione.md)
- [Manuale Utente](doc/manuale.md)

## Installazione
Se si vuole installare localmente o su un proprio server la piattaforma è necessario che siano installati un Server HTTP con PHP abilitato a ricevere file caricati dall'utente, e una istanza MySQL
con un database chiamato "my_enricociciriello" con user "enricociciriello" e password vuota.