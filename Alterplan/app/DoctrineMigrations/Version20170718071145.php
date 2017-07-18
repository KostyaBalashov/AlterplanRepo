<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170718071145 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mssql', 'Migration can only be executed safely on \'mssql\'.');

        $this->addSql('ALTER TABLE Calendrier DROP CONSTRAINT FK_Calendrier_Stagiaire1');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN CodeCalendrier INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN CodeFormation NVARCHAR(8)');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN IsInscrit BIT NOT NULL');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN IsModele BIT NOT NULL');
        $this->addSql('ALTER TABLE Calendrier ADD CONSTRAINT FK_FD283F69A9AC032C FOREIGN KEY (CodeStagiaire) REFERENCES Stagiaire (CodeStagiaire)');
        $this->addSql('ALTER TABLE Contrainte DROP CONSTRAINT FK_Contrainte_Calendrier1');
        $this->addSql('ALTER TABLE Contrainte ALTER COLUMN CodeContrainte INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE Contrainte ALTER COLUMN CodeTypeContrainte INT');
        $this->addSql('ALTER TABLE Contrainte ALTER COLUMN Calendrier_CodeCalendrier INT');
        $this->addSql('ALTER TABLE Contrainte ADD CONSTRAINT FK_58CF59A0F7BD16B7 FOREIGN KEY (Calendrier_CodeCalendrier) REFERENCES Calendrier (CodeCalendrier)');
        $this->addSql('ALTER TABLE Cours DROP CONSTRAINT FK_Cours_Promotion');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN CodePromotion NVARCHAR(8)');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN IdCours UNIQUEIDENTIFIER NOT NULL');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN IdModule INT');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN CodeSalle NVARCHAR(5)');
        $this->addSql('ALTER TABLE Cours ADD CONSTRAINT FK_3C0BA39827D389CC FOREIGN KEY (CodePromotion) REFERENCES Promotion (CodePromotion)');
        $this->addSql('ALTER TABLE Dispense DROP CONSTRAINT FK_Dispense_ModuleCalendrier1');
        $this->addSql('ALTER TABLE Dispense ALTER COLUMN CodeDispense INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE Dispense ADD CONSTRAINT FK_D5C4DB11C7EE6FE3 FOREIGN KEY (CodeModuleCalendrier) REFERENCES ModuleCalendrier (CodeModuleCalendrier)');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN CodePostal NVARCHAR(5)');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN Telephone NVARCHAR(14)');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN Fax NVARCHAR(14)');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN CodeTypeEntreprise NVARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN CodeRegion NVARCHAR(2) NOT NULL');
        $this->addSql('ALTER TABLE Formation ALTER COLUMN CodeFormation NVARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE Formation ALTER COLUMN CodeTitre NVARCHAR(8)');
        $this->addSql('ALTER TABLE GroupeModule DROP CONSTRAINT FK_GroupeModule_OrdreModule1');
        $this->addSql('ALTER TABLE GroupeModule DROP CONSTRAINT FK_SousGroupeModule_Module_1');
        $this->addSql('ALTER TABLE GroupeModule DROP CONSTRAINT FK_SousGroupeModule_Module_2');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_CC2CDA2A6C9CD65A\')
                            ALTER TABLE GroupeModule DROP CONSTRAINT IDX_CC2CDA2A6C9CD65A
                        ELSE
                            DROP INDEX IDX_CC2CDA2A6C9CD65A ON GroupeModule');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_CC2CDA2AF59587E0\')
                            ALTER TABLE GroupeModule DROP CONSTRAINT IDX_CC2CDA2AF59587E0
                        ELSE
                            DROP INDEX IDX_CC2CDA2AF59587E0 ON GroupeModule');
        $this->addSql('ALTER TABLE GroupeModule ALTER COLUMN CodeGroupeModule INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE GroupeModule ALTER COLUMN CodeOrdreModule INT');
        $this->addSql('ALTER TABLE GroupeModule ADD CONSTRAINT FK_CC2CDA2A93959DDA FOREIGN KEY (CodeOrdreModule) REFERENCES OrdreModule (CodeOrdreModule)');
        $this->addSql('ALTER TABLE ModuleCalendrier DROP CONSTRAINT FK_ModuleCalendrier_Module');
        $this->addSql('ALTER TABLE ModuleCalendrier DROP CONSTRAINT FK_ModuleCalendrier_Calendrier');
        $this->addSql('ALTER TABLE ModuleCalendrier ALTER COLUMN CodeModuleCalendrier INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE ModuleCalendrier ALTER COLUMN CodeCalendrier INT');
        $this->addSql('ALTER TABLE ModuleCalendrier ADD CONSTRAINT FK_FDEAFAC19643ECE4 FOREIGN KEY (IdModule) REFERENCES Module (IdModule)');
        $this->addSql('ALTER TABLE ModuleCalendrier ADD CONSTRAINT FK_FDEAFAC1D1959E94 FOREIGN KEY (CodeCalendrier) REFERENCES Calendrier (CodeCalendrier)');
        $this->addSql('ALTER TABLE ModuleParUnite DROP CONSTRAINT FK_ModuleParUnite_UniteParFormation');
        $this->addSql('ALTER TABLE ModuleParUnite ALTER COLUMN IdUnite INT');
        $this->addSql('ALTER TABLE ModuleParUnite ALTER COLUMN IdModule INT');
        $this->addSql('ALTER TABLE ModuleParUnite ADD CONSTRAINT FK_53FF7989C51DBB99 FOREIGN KEY (IdUnite) REFERENCES UniteParFormation (Id)');
        $this->addSql('ALTER TABLE OrdreModule DROP CONSTRAINT FK_OrdreModule_Module1');
        $this->addSql('ALTER TABLE OrdreModule DROP CONSTRAINT FK_OrdreModule_Formation1');
        $this->addSql('ALTER TABLE OrdreModule ALTER COLUMN CodeOrdreModule INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE OrdreModule ALTER COLUMN CodeFormation NVARCHAR(8)');
        $this->addSql('ALTER TABLE OrdreModule ALTER COLUMN IdModule INT');
        $this->addSql('ALTER TABLE OrdreModule ADD CONSTRAINT FK_50B5AEDA9643ECE4 FOREIGN KEY (IdModule) REFERENCES Module (IdModule)');
        $this->addSql('ALTER TABLE OrdreModule ADD CONSTRAINT FK_50B5AEDAA68ED5A2 FOREIGN KEY (CodeFormation) REFERENCES Formation (CodeFormation)');
        $this->addSql('ALTER TABLE Promotion DROP CONSTRAINT FK_Promotion_Lieu1');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_43ECFF72D3589E61\')
                            ALTER TABLE Promotion DROP CONSTRAINT IDX_43ECFF72D3589E61
                        ELSE
                            DROP INDEX IDX_43ECFF72D3589E61 ON Promotion');
        $this->addSql('ALTER TABLE Promotion ALTER COLUMN CodePromotion NVARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE Promotion ALTER COLUMN CodeFormation NVARCHAR(8)');
        $this->addSql('ALTER TABLE Salle DROP CONSTRAINT FK_Salle_Lieu1');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_8F5651588F65D267\')
                            ALTER TABLE Salle DROP CONSTRAINT IDX_8F5651588F65D267
                        ELSE
                            DROP INDEX IDX_8F5651588F65D267 ON Salle');
        $this->addSql('ALTER TABLE Salle ALTER COLUMN CodeSalle NVARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE SousGroupeModule DROP CONSTRAINT FK_SousGroupeModule_Module1');
        $this->addSql('ALTER TABLE SousGroupeModule DROP CONSTRAINT FK_SousGroupeModule_Module2');
        $this->addSql('ALTER TABLE SousGroupeModule DROP CONSTRAINT FK_SousGroupeModule_Module3');
        $this->addSql('ALTER TABLE SousGroupeModule DROP CONSTRAINT FK_SousGroupeModule_Module4');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_C597609A79D85AF7\')
                            ALTER TABLE SousGroupeModule DROP CONSTRAINT IDX_C597609A79D85AF7
                        ELSE
                            DROP INDEX IDX_C597609A79D85AF7 ON SousGroupeModule');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_C597609AE0D10B4D\')
                            ALTER TABLE SousGroupeModule DROP CONSTRAINT IDX_C597609AE0D10B4D
                        ELSE
                            DROP INDEX IDX_C597609AE0D10B4D ON SousGroupeModule');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_C597609A97D63BDB\')
                            ALTER TABLE SousGroupeModule DROP CONSTRAINT IDX_C597609A97D63BDB
                        ELSE
                            DROP INDEX IDX_C597609A97D63BDB ON SousGroupeModule');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_C597609A9B2AE78\')
                            ALTER TABLE SousGroupeModule DROP CONSTRAINT IDX_C597609A9B2AE78
                        ELSE
                            DROP INDEX IDX_C597609A9B2AE78 ON SousGroupeModule');
        $this->addSql('ALTER TABLE SousGroupeModule ADD IdModule INT');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN CodeSousGroupeModule INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module1 NVARCHAR(45)');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module2 NVARCHAR(45)');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module3 NVARCHAR(45)');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module4 NVARCHAR(45)');
        $this->addSql('ALTER TABLE SousGroupeModule ADD CONSTRAINT FK_C597609A9643ECE4 FOREIGN KEY (IdModule) REFERENCES Module (IdModule)');
        $this->addSql('CREATE INDEX IDX_C597609A9643ECE4 ON SousGroupeModule (IdModule)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN Civilite NVARCHAR(3)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN Codepostal NVARCHAR(5)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN TelephoneFixe NVARCHAR(14)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN TelephonePortable NVARCHAR(14)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN CodeRegion NVARCHAR(2)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN CodeNationalite NVARCHAR(2)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN CodeOrigineMedia NVARCHAR(3)');
        $this->addSql('ALTER TABLE StagiaireParEntreprise DROP CONSTRAINT FK_StagiaireParEntreprise_Entreprise');
        $this->addSql('ALTER TABLE StagiaireParEntreprise DROP CONSTRAINT FK_StagiaireParEntreprise_Stagiaire1');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_B7E5F9466EF9584D\')
                            ALTER TABLE StagiaireParEntreprise DROP CONSTRAINT IDX_B7E5F9466EF9584D
                        ELSE
                            DROP INDEX IDX_B7E5F9466EF9584D ON StagiaireParEntreprise');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_B7E5F946A9AC032C\')
                            ALTER TABLE StagiaireParEntreprise DROP CONSTRAINT IDX_B7E5F946A9AC032C
                        ELSE
                            DROP INDEX IDX_B7E5F946A9AC032C ON StagiaireParEntreprise');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ALTER COLUMN CodeTypeLien NVARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ALTER COLUMN CodeFonction NVARCHAR(5)');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ALTER COLUMN TitreVise NVARCHAR(5)');
        $this->addSql('ALTER TABLE TypeContrainte ALTER COLUMN CodeTypeContrainte INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE UniteParFormation DROP CONSTRAINT FK_UniteParFormation_Formation');
        $this->addSql('ALTER TABLE UniteParFormation ALTER COLUMN CodeFormation NVARCHAR(8)');
        $this->addSql('ALTER TABLE UniteParFormation ALTER COLUMN IdUniteFormation INT');
        $this->addSql('ALTER TABLE UniteParFormation ADD CONSTRAINT FK_C1E36CE8A68ED5A2 FOREIGN KEY (CodeFormation) REFERENCES Formation (CodeFormation)');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN CodeUtilisateur INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN email NVARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN IsAdministrateur VARBINARY(255) NOT NULL');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN password NVARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mssql', 'Migration can only be executed safely on \'mssql\'.');

        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('ALTER TABLE Calendrier DROP CONSTRAINT FK_FD283F69A9AC032C');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN CodeCalendrier INT NOT NULL');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN IsInscrit BINARY(255) NOT NULL');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN IsModele BINARY(255) NOT NULL');
        $this->addSql('ALTER TABLE Calendrier ALTER COLUMN CodeFormation NCHAR(8) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE Calendrier ADD CONSTRAINT FK_Calendrier_Stagiaire1 FOREIGN KEY (CodeStagiaire) REFERENCES Stagiaire (CodeStagiaire) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Contrainte DROP CONSTRAINT FK_58CF59A0F7BD16B7');
        $this->addSql('ALTER TABLE Contrainte ALTER COLUMN CodeContrainte INT NOT NULL');
        $this->addSql('ALTER TABLE Contrainte ALTER COLUMN Calendrier_CodeCalendrier INT NOT NULL');
        $this->addSql('ALTER TABLE Contrainte ALTER COLUMN CodeTypeContrainte INT NOT NULL');
        $this->addSql('ALTER TABLE Contrainte ADD CONSTRAINT FK_Contrainte_Calendrier1 FOREIGN KEY (Calendrier_CodeCalendrier) REFERENCES Calendrier (CodeCalendrier) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Cours DROP CONSTRAINT FK_3C0BA39827D389CC');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN IdCours UNIQUEIDENTIFIER NOT NULL');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN CodeSalle NCHAR(5) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN IdModule INT NOT NULL');
        $this->addSql('ALTER TABLE Cours ALTER COLUMN CodePromotion NCHAR(8) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Cours ADD CONSTRAINT FK_Cours_Promotion FOREIGN KEY (CodePromotion) REFERENCES Promotion (CodePromotion) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Dispense DROP CONSTRAINT FK_D5C4DB11C7EE6FE3');
        $this->addSql('ALTER TABLE Dispense ALTER COLUMN CodeDispense INT NOT NULL');
        $this->addSql('ALTER TABLE Dispense ADD CONSTRAINT FK_Dispense_ModuleCalendrier1 FOREIGN KEY (CodeModuleCalendrier) REFERENCES ModuleCalendrier (CodeModuleCalendrier) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN CodePostal NCHAR(5) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN Telephone NCHAR(14) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN Fax NCHAR(14) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN CodeTypeEntreprise NCHAR(5) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE Entreprise ALTER COLUMN CodeRegion NCHAR(2) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE Formation ALTER COLUMN CodeFormation NCHAR(8) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE Formation ALTER COLUMN CodeTitre NCHAR(8) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE GroupeModule DROP CONSTRAINT FK_CC2CDA2A93959DDA');
        $this->addSql('ALTER TABLE GroupeModule ALTER COLUMN CodeGroupeModule INT NOT NULL');
        $this->addSql('ALTER TABLE GroupeModule ALTER COLUMN CodeOrdreModule INT NOT NULL');
        $this->addSql('ALTER TABLE GroupeModule ADD CONSTRAINT FK_GroupeModule_OrdreModule1 FOREIGN KEY (CodeOrdreModule) REFERENCES OrdreModule (CodeOrdreModule) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE GroupeModule ADD CONSTRAINT FK_SousGroupeModule_Module_1 FOREIGN KEY (CodeSousGroupe1) REFERENCES SousGroupeModule (CodeSousGroupeModule) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE GroupeModule ADD CONSTRAINT FK_SousGroupeModule_Module_2 FOREIGN KEY (CodeSousGroupe2) REFERENCES SousGroupeModule (CodeSousGroupeModule) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CC2CDA2A6C9CD65A ON GroupeModule (CodeSousGroupe1)');
        $this->addSql('CREATE INDEX IDX_CC2CDA2AF59587E0 ON GroupeModule (CodeSousGroupe2)');
        $this->addSql('ALTER TABLE ModuleCalendrier DROP CONSTRAINT FK_FDEAFAC19643ECE4');
        $this->addSql('ALTER TABLE ModuleCalendrier DROP CONSTRAINT FK_FDEAFAC1D1959E94');
        $this->addSql('ALTER TABLE ModuleCalendrier ALTER COLUMN CodeModuleCalendrier INT NOT NULL');
        $this->addSql('ALTER TABLE ModuleCalendrier ALTER COLUMN CodeCalendrier INT NOT NULL');
        $this->addSql('ALTER TABLE ModuleCalendrier ADD CONSTRAINT FK_ModuleCalendrier_Module FOREIGN KEY (IdModule) REFERENCES Module (IdModule) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ModuleCalendrier ADD CONSTRAINT FK_ModuleCalendrier_Calendrier FOREIGN KEY (CodeCalendrier) REFERENCES Calendrier (CodeCalendrier) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ModuleParUnite DROP CONSTRAINT FK_53FF7989C51DBB99');
        $this->addSql('ALTER TABLE ModuleParUnite ALTER COLUMN IdModule INT NOT NULL');
        $this->addSql('ALTER TABLE ModuleParUnite ALTER COLUMN IdUnite INT NOT NULL');
        $this->addSql('ALTER TABLE ModuleParUnite ADD CONSTRAINT FK_ModuleParUnite_UniteParFormation FOREIGN KEY (IdUnite) REFERENCES UniteParFormation (Id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE OrdreModule DROP CONSTRAINT FK_50B5AEDA9643ECE4');
        $this->addSql('ALTER TABLE OrdreModule DROP CONSTRAINT FK_50B5AEDAA68ED5A2');
        $this->addSql('ALTER TABLE OrdreModule ALTER COLUMN CodeOrdreModule INT NOT NULL');
        $this->addSql('ALTER TABLE OrdreModule ALTER COLUMN IdModule INT NOT NULL');
        $this->addSql('ALTER TABLE OrdreModule ALTER COLUMN CodeFormation NCHAR(8) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE OrdreModule ADD CONSTRAINT FK_OrdreModule_Module1 FOREIGN KEY (IdModule) REFERENCES Module (IdModule) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE OrdreModule ADD CONSTRAINT FK_OrdreModule_Formation1 FOREIGN KEY (CodeFormation) REFERENCES Formation (CodeFormation) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Promotion ALTER COLUMN CodePromotion NCHAR(8) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE Promotion ALTER COLUMN CodeFormation NCHAR(8) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE Promotion ADD CONSTRAINT FK_Promotion_Lieu1 FOREIGN KEY (CodeLieu) REFERENCES Lieu (CodeLieu) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_43ECFF72D3589E61 ON Promotion (CodeLieu)');
        $this->addSql('ALTER TABLE Salle ALTER COLUMN CodeSalle NVARCHAR(5) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE Salle ADD CONSTRAINT FK_Salle_Lieu1 FOREIGN KEY (Lieu) REFERENCES Lieu (CodeLieu) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8F5651588F65D267 ON Salle (Lieu)');
        $this->addSql('ALTER TABLE SousGroupeModule DROP CONSTRAINT FK_C597609A9643ECE4');
        $this->addSql('IF EXISTS (SELECT * FROM sysobjects WHERE name = \'IDX_C597609A9643ECE4\')
                            ALTER TABLE SousGroupeModule DROP CONSTRAINT IDX_C597609A9643ECE4
                        ELSE
                            DROP INDEX IDX_C597609A9643ECE4 ON SousGroupeModule');
        $this->addSql('ALTER TABLE SousGroupeModule DROP COLUMN IdModule');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN CodeSousGroupeModule INT NOT NULL');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module1 INT');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module2 INT');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module3 INT');
        $this->addSql('ALTER TABLE SousGroupeModule ALTER COLUMN Module4 INT');
        $this->addSql('ALTER TABLE SousGroupeModule ADD CONSTRAINT FK_SousGroupeModule_Module1 FOREIGN KEY (Module1) REFERENCES Module (IdModule) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE SousGroupeModule ADD CONSTRAINT FK_SousGroupeModule_Module2 FOREIGN KEY (Module2) REFERENCES Module (IdModule) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE SousGroupeModule ADD CONSTRAINT FK_SousGroupeModule_Module3 FOREIGN KEY (Module3) REFERENCES Module (IdModule) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE SousGroupeModule ADD CONSTRAINT FK_SousGroupeModule_Module4 FOREIGN KEY (Module4) REFERENCES Module (IdModule) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C597609A79D85AF7 ON SousGroupeModule (Module1)');
        $this->addSql('CREATE INDEX IDX_C597609AE0D10B4D ON SousGroupeModule (Module2)');
        $this->addSql('CREATE INDEX IDX_C597609A97D63BDB ON SousGroupeModule (Module3)');
        $this->addSql('CREATE INDEX IDX_C597609A9B2AE78 ON SousGroupeModule (Module4)');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN Civilite NCHAR(3) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN Codepostal NCHAR(5) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN TelephoneFixe NCHAR(14) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN TelephonePortable NCHAR(14) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN CodeRegion NCHAR(2) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN CodeNationalite NCHAR(2) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Stagiaire ALTER COLUMN CodeOrigineMedia NCHAR(3) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ALTER COLUMN CodeTypeLien NCHAR(5) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ALTER COLUMN CodeFonction NCHAR(5) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ALTER COLUMN TitreVise NCHAR(5) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ADD CONSTRAINT FK_StagiaireParEntreprise_Entreprise FOREIGN KEY (CodeEntreprise) REFERENCES Entreprise (CodeEntreprise) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE StagiaireParEntreprise ADD CONSTRAINT FK_StagiaireParEntreprise_Stagiaire1 FOREIGN KEY (CodeStagiaire) REFERENCES Stagiaire (CodeStagiaire) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_B7E5F9466EF9584D ON StagiaireParEntreprise (CodeEntreprise)');
        $this->addSql('CREATE INDEX IDX_B7E5F946A9AC032C ON StagiaireParEntreprise (CodeStagiaire)');
        $this->addSql('ALTER TABLE TypeContrainte ALTER COLUMN CodeTypeContrainte INT NOT NULL');
        $this->addSql('ALTER TABLE UniteParFormation DROP CONSTRAINT FK_C1E36CE8A68ED5A2');
        $this->addSql('ALTER TABLE UniteParFormation ALTER COLUMN CodeFormation NCHAR(8) COLLATE French_CI_AS NOT NULL');
        $this->addSql('ALTER TABLE UniteParFormation ALTER COLUMN IdUniteFormation INT NOT NULL');
        $this->addSql('ALTER TABLE UniteParFormation ADD CONSTRAINT FK_UniteParFormation_Formation FOREIGN KEY (CodeFormation) REFERENCES Formation (CodeFormation) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN Email NVARCHAR(100) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN Password VARCHAR(MAX) COLLATE French_CI_AS');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN CodeUtilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE Utilisateur ALTER COLUMN IsAdministrateur BINARY(255)');
    }
}
