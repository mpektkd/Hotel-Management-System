set @Descr = "Grande";
set @Reg = "Restaurant";

select 
	BraceletId,
	idRegions, 
    Datetime as EntryDatetime,
	(
	SELECT min(q.Datetime) FROM mydb.PassingEntry as q
		where BraceletId=1 and Approvement = 1
        and q.Datetime > a.Datetime
		and idEntriesToRegions 
			in(
			select idEntriesToRegions from EntriesToRegions
				where idRegionsFrom=131
				) group by Datetime
    )as ExitDatetime
    from
	(
	SELECT * FROM mydb.PassingEntry
		where BraceletId=1 and Approvement = 1
		and idEntriesToRegions in (
			select idEntriesToRegions from EntriesToRegions
				where idRegionsTo=
				(
					select idRegions from Regions
						where Description_Place like CONCAT('%', @Descr, '%')
							and RegionName like CONCAT('%', @Reg, '%')
				)
			)
	)as a
join EntriesToRegions as b on b.idEntriesToRegions=a.idEntriesToRegions
join Regions as c on c.idRegions=b.idRegionsTo
;

SELECT Datetime FROM mydb.PassingEntry
where BraceletId=1 and Approvement = 1
and idEntriesToRegions in(
	select idEntriesToRegions from EntriesToRegions
		where idRegionsFrom=131
)

;
-- DELIMITER $$
-- 
-- CREATE PROCEDURE CustomerVisit(
-- 	rid int,
--     BId INT
-- ) 
-- DETERMINISTIC
-- BEGIN
-- 
--     select 
-- 		
--         BraceletId,
-- 		idRegions, 
-- 		Datetime as EntryDatetime,
-- 		(
-- 		SELECT min(Datetime) FROM mydb.PassingEntry as q
-- 			where BraceletId=Bid and Approvement = 1
--             and q.Datetime >  a.Datetime
-- 			and idEntriesToRegions 
-- 				in(
-- 				select idEntriesToRegions from EntriesToRegions
-- 					where idRegionsFrom=rid
-- 					) group by Datetime
-- 		)as ExitDatetime
--         
--     from
-- 	(
-- 		SELECT * FROM mydb.PassingEntry as a
-- 			where a.BraceletId=BId and Approvement = 1
-- 			and idEntriesToRegions in (
-- 				select idEntriesToRegions from EntriesToRegions
-- 					where idRegionsTo = rid
-- 				)
-- 			)as a
-- 		join EntriesToRegions as b on b.idEntriesToRegions=a.idEntriesToRegions
-- 		join Regions as c on c.idRegions=b.idRegionsTo
-- 		;
-- 
-- END$$
-- DELIMITER ;

CALL CustomerVisit(103, 2);