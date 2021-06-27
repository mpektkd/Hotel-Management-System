-- create view TotalCostPerBracelet as 
select f.BraceletId, f.Cost, g.TotalBill 
from (
	select BraceletId, sum(Cost) as Cost 
    from(
		select a.BraceletId, a.Cost, b.TotalBill 
        from(
			select BraceletId, sum(CostAmount)as Cost 
            from ServiceCharge
			group by BraceletId
			)as a
			join ActiveCustomerLiveToRooms as b on b.BraceletId=a.BraceletId

			union

			select BraceletId, datediff(LeavingDatetime, ArrivalDatetime)*ChargePerDay, TotalBill  
			from ActiveCustomerLiveToRooms as a
			join Room as b on b.idRoom=a.idRoom
			
			union 
			
			select a.BraceletId, CostAmount, TotalBill 
			from SubscriptionToServices as a
			join ActiveCustomerLiveToRooms as b on b.BraceletId=a.BraceletId

		) as q
		group by BraceletId

	)as f
	join 

	(
	select BraceletId, TotalBill from ActiveCustomerLiveToRooms
	) as g on g.BraceletId=f.BraceletId
	;	