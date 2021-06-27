DELIMITER $$

CREATE TRIGGER after_insert_passing
AFTER INSERT
ON PassingEntry 
FOR EACH ROW
BEGIN

	DECLARE regto, regfrom, cid int;
    
	select idRegionsTo, idRegionsFrom from EntriesToRegions
		where idEntriesToRegions=new.idEntriesToRegions 
		into regto, regfrom;
		
        
	set cid = (select idCustomerVisitRegions
		from CustomerVisitRegions
		where idRegions = regfrom
        and idCustomerVisitRegions is not null
        and ExitDatetime is null
        and EntryDatetime <= new.Datetime
        limit 0,1);
        
        
		if ( cid is not null ) then
    
			update CustomerVisitRegions
				set ExitDatetime = new.Datetime
					where idCustomerVisitRegions=cid;
        
        end if;
        
        insert into CustomerVisitRegions (BraceletId, idRegions, EntryDatetime, ExitDatetime)
			values(new.BraceletId, regto, new.Datetime, null);
        
END$$
DELIMITER ;
