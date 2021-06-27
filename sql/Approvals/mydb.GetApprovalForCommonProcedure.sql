DELIMITER $$

CREATE PROCEDURE GetApprovalForCommon(
bid int
) 
DETERMINISTIC
BEGIN
	-- Insertion of available Entries at Room's Floor
	insert into ApprovedEntries(BraceletId, idEntriesToRegions)
	select 
		Bracelet as BraceletId,
		idEntriesToRegions
	from (
	(select
		a.BraceletId as Bracelet,
		e.Description_Place as Description_Place,
		e.Floor as Floor,
		g.Description_EntryPoint as Entry,
		g.idRegionsFrom as idRegionFrom,
		g.idRegionsTo as idRegionTo
		
		from ActiveCustomerLiveToRooms as a
	join Room as d on d.idRoom = a.idRoom
	join Regions as e on e.idRegions=d.idRoom
	join EntriesToRegions as f on f.idRegionsTo=d.idRoom
	join EntriesToRegions as g on g.idRegionsFrom=f.idRegionsFrom 
	where g.idRegionsTo=d.idRoom or g.Description_EntryPoint like "%Elavator%" 
	order by a.BraceletId 
	)
	union
	(select 
		Bracelet,
		j.Description_Place,
		j.Floor,
		k.Description_EntryPoint as Entry,
		k.idRegionsFrom as idRegionFrom,
		k.idRegionsTo as idRegionTo
		
	 from (select
		a.BraceletId as Bracelet,
		e.Description_Place as Description_Place,
		e.Floor as Floor,
		g.Description_EntryPoint as Entry,
		g.idRegionsFrom as idRegionFrom,
		g.idRegionsTo as idRegionTo
		from ActiveCustomerLiveToRooms as a
	join Room as d on d.idRoom = a.idRoom
	join Regions as e on e.idRegions=d.idRoom
	join EntriesToRegions as f on f.idRegionsTo=d.idRoom
	join EntriesToRegions as g on g.idRegionsFrom=f.idRegionsFrom 
	where g.idRegionsTo=d.idRoom or g.Description_EntryPoint like "%Elavator%" 
	order by a.BraceletId 
	)as j
	join EntriesToRegions k on k.idRegionsFrom=j.idRegionTo
	join Regions l on k.idRegionsTo=l.idRegions
	where l.Floor=j.Floor
	)
	order by Bracelet)as n
	join EntriesToRegions m on m.idRegionsFrom=n.idRegionFrom and m.idRegionsTo=n.idRegionTo
	where Bracelet=bid
	;

	-- Insertion of available Entries at NotsubscribedServices at Ground Floor
	insert into ApprovedEntries(BraceletId, idEntriesToRegions)
	select BraceletId, idEntriesToRegions  from ActiveCustomerLiveToRooms as q
	cross join
	(
	select distinct idEntriesToRegions from 
	(
	select 
		a.idServices as idServices,
		b.idOtherRegions as idOtherRegions,
		a.Description as Description
	 from 
	(
	select 
		idServices, 
		Description
	 from Services
	where idServices in (1,2,3)
	) as a
	join ServicesAtSpecifiedRegions as b on a.idServices=b.idServices
	) as c
	join EntriesToRegions as d on d.idRegionsFrom=c.idOtherRegions or d.idRegionsTo=c.idOtherRegions
	)as w
	where BraceletId=bid
	;

	-- Insertion of available Entries for Elavators-from/to-Corridors at Ground Floor
	insert into ApprovedEntries(BraceletId, idEntriesToRegions)
	select BraceletId, idEntriesToRegions from ActiveCustomerLiveToRooms as d
	cross join
	(
	select idEntriesToRegions from(
	SELECT * FROM mydb.EntriesToRegions
	where idRegionsFrom in (121,122,123,124) and idRegionsTo in (101,102,103,104)
	union

	SELECT * FROM mydb.EntriesToRegions
	where idRegionsTo in (121,122,123,124) and idRegionsFrom in (101,102,103,104)
	)as a
	)as e
	where BraceletId=bid
	;

	-- Insertion of available Entries for Corridors at Ground Floor
	insert into ApprovedEntries(BraceletId, idEntriesToRegions)
	select BraceletId, idEntriesToRegions from ActiveCustomerLiveToRooms as a
	cross join 
	(
	select idEntriesToRegions from EntriesToRegions
	where idEntriesToRegions in (305, 306, 307, 308, 309, 310, 311, 312)
	)as b
	where BraceletId=bid;

END$$
DELIMITER ;

