GO
use master

--/ Close Connection, then Drop DB if exists --/
WHILE EXISTS(select NULL from sys.databases where name='eenmaalandermaal')
BEGIN
    DECLARE @SQL varchar(max)
    SELECT @SQL = COALESCE(@SQL,'') + 'Kill ' + Convert(varchar, SPId) + ';'
    FROM MASTER..SysProcesses
    WHERE DBId = DB_ID(N'eenmaalandermaal') AND SPId <> @@SPId
    EXEC(@SQL)
    DROP DATABASE [eenmaalandermaal]
END



GO
IF EXISTS(select * from sys.databases where name='eenmaalandermaal')
	DROP DATABASE eenmaalandermaal
GO


GO
create DATABASE eenmaalandermaal
