--Dit bestand bevat alle conversiescripts om de

use eenmaalandermaal
--Conversiescript rubrieken
INSERT INTO eenmaalandermaal.dbo.Rubriek
  SELECT ID AS RB_Nummer,
         name AS RB_naam,
         parent AS RB_parent,
         ID AS RB_volgnummer
  FROM veilingsite.dbo.Categorieen