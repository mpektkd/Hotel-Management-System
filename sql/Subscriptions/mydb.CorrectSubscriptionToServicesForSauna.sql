insert into SubscriptionToServices (BraceletId, idServices, SubscriptionDatetime)
select 
	q.BraceletId,
    4 as idServices,
    q.ArrivalDatetime
    
 from(
select 

	a.BraceletId,
    a.ArrivalDatetime
    

 from ActiveCustomerLiveToRooms as a
join ServiceCharge as b on b.BraceletId=a.BraceletId
join ServiceMenu as c on c.idServiceMenu=b.idServiceMenu
where c.Description like "%Spa%" or c.Description like "%Jacuzzi%" 
)as q
left join
(
select 

	a.BraceletId
    
 from ActiveCustomerLiveToRooms as a
join SubscriptionToServices b on b.BraceletId=a.BraceletId
where b.idServices=4
)as w on w.BraceletId=q.BraceletId
where w.BraceletId is null
;
