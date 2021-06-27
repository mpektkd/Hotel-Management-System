DELIMITER $$

CREATE PROCEDURE GetApprovalForSubscribed(
bid int,
sid int
) 
DETERMINISTIC
BEGIN

-- Insertion of available Entries for SubsrcibedServices at Ground Floor
	insert into ApprovedEntries(BraceletId, idEntriesToRegions)
	select * from
	(
	select 
		g.BraceletId as BraceletId,
		h.idEntriesToRegions as idEntriesToRegions
	 from (

	select 

		e.BraceletId as BraceletId,
		e.idServices as idServices,
		f.idServices as idSubscribed,
		f.idOtherRegions as idOtherRegions
		
	 from
	(
	select 
		c.BraceletId as BraceletId,
		c.idServices as idServices,
		d.idSubscribed as idSubscribed
		
	 from 
	(select 
		a.BraceletId as BraceletId,
		b.idServices as idServices
	from ActiveCustomerLiveToRooms as a
	join SubscriptionToServices as b on a.BraceletId=b.BraceletId
	where a.BraceletId=bid and b.idServices=sid
	order by a.BraceletId
	) as c
	join SubscribedServices d on c.idServices=d.idSubscribed
	) as e
	join ServicesAtSpecifiedRegions as f on e.idSubscribed=f.idServices
	order by BraceletId
	) as g
	join EntriesToRegions as h on h.idRegionsFrom=g.idOtherRegions or h.idRegionsTo=g.idOtherRegions
	where (h.idRegionsFrom=g.idOtherRegions and (h.Description_EntryPoint like "%Corridor%" or 
	(g.BraceletId, h.idRegionsTo) in 
	(
	select 
		e.BraceletId as BraceletId,
		f.idOtherRegions as idOtherRegions
		
	 from
	(
	select 
		c.BraceletId as BraceletId,
		c.idServices as idServices,
		d.idSubscribed as idSubscribed
		
	 from 
	(select 
		a.BraceletId as BraceletId,
		b.idServices as idServices
	from ActiveCustomerLiveToRooms as a
	join SubscriptionToServices as b on a.BraceletId=b.BraceletId
    where a.BraceletId=bid 
	order by a.BraceletId
	) as c
	join SubscribedServices d on c.idServices=d.idSubscribed
	) as e
	join ServicesAtSpecifiedRegions as f on e.idSubscribed=f.idServices
	)
	))
	or (h.idRegionsTo=g.idOtherRegions and 
			((g.BraceletId, h.idRegionsFrom )
				in
					(
					select 
						e.BraceletId as BraceletId,
						f.idOtherRegions as idOtherRegions
						
					 from
					(
					select 
						c.BraceletId as BraceletId,
						c.idServices as idServices,
						d.idSubscribed as idSubscribed
						
					 from 
					(select 
						a.BraceletId as BraceletId,
						b.idServices as idServices
					from ActiveCustomerLiveToRooms as a
					join SubscriptionToServices as b on a.BraceletId=b.BraceletId
					where a.BraceletId=bid
					order by a.BraceletId
					) as c
					join SubscribedServices d on c.idServices=d.idSubscribed
					) as e
					join ServicesAtSpecifiedRegions as f on e.idSubscribed=f.idServices
					)
					or h.idRegionsFrom in (101,102,103,104) -- Ground Floor Corridors ids
					) )
					order by BraceletId
			)as wq
			where wq.BraceletId=bid
            order by wq.idEntriesToRegions;

END$$
DELIMITER ;
