use eenmaalandermaal;
IF OBJECT_ID('dbo.aantalBestandenPervoorwerpnummer') IS NOT NULL
  drop function [dbo].[aantalBestandenPerVoorwerpnummer]
go
CREATE FUNCTION aantalBestandenPerVoorwerpnummer(
  field BIGINT
)RETURNS int
  BEGIN
    RETURN(
      SELECT COUNT(voorwerpnummer)
      FROM Bestand
      WHERE voorwerpnummer = @field
    )
  end


