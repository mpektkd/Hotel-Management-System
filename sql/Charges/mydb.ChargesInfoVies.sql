create view ChargesInfo as 
SELECT 
	
    a.BraceletId,
	b.idServiceCharge as idServiceCharge,
    e.Description as Service,
    d.Description as Product,
    CostPerUnit,
    Quantity,
    CostAmount,
    Description_Place,
    RegionName,
    Datetime,
    isPaid

 from ActiveCustomerLiveToRooms as a
join ServiceCharge as b on b.BraceletId=a.BraceletId
join Regions as c on c.idRegions=b.idRegions
join ServiceMenu as d on d.idServiceMenu=b.idServiceMenu
join Services as e on e.idServices=d.idServices
order by a.BraceletId
