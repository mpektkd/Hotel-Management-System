-- create view MenuStatsLastSixMonths as 

select 
		a.idServiceMenu as idServiceMenu,
        a.Description as Description,
        sum(b.Quantity) as TotalConsumption,
        sum(b.CostAmount) as TotalProfit,
        a.CostPerUnit as CostPerUnit,
        f.Description as Service
        


 from ServiceMenu as a
join ServiceCharge as b on a.idServiceMenu=b.idServiceMenu
join Services as f on f.idServices=a.idServices
join Regions as d on d.idRegions=b.idRegions
where b.DateTime between "2021-01-01 00:00:00" and CONCAT(CURRENT_DATE, " ", CURRENT_TIME())
and f.idServices in (1,2,3)
group by b.idServiceMenu,f.Description 
union 



select 
	distinct
	idServiceMenu,
	qq.Description,
    TotalConsumption,
    TotalProfit,
    CostPerUnit,
    Service
    
from(
select 
	
    f.idServiceMenu as idServiceMenu,
    datediff(a.LeavingDatetime, a.ArrivalDatetime)*CostPerDay as TotalProfit,
    c.CostPerDay as CostPerUnit,
    f.Description as Description,
	d.Description as Service
        
    

 from ActiveCustomerLiveToRooms as a
join SubscriptionToServices as b on b.BraceletId=a.BraceletId
join SubscribedServices as c on c.idSubscribed=b.idServices
join Services as d on d.idServices=c.idSubscribed
join ServiceMenu as f on f.idServices=d.idServices
)as qq
join 
(select 
	f.Description, 
	count(*) as TotalConsumption
from SubscriptionToServices as a
join Services as b on b.idServices=a.idServices
join ServiceMenu as f on f.idServices=b.idServices
group by f.idServiceMenu)as qw on qw.Description=qq.Description
;