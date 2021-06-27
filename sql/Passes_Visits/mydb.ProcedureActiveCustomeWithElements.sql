SELECT 
		BraceletId,
		LastName,
        FirstName,
        SINNumber,
		ArrivalDatetime, 
		LeavingDatetime,
        TotalBill,
        Description_Place
	FROM 
(SELECT 
		LastName,
        FirstName,
        SINNumber,
        a.idCustomer
	FROM Customer as a
	join SIN as b on b.idCustomer=a.idCustomer
    where SINNumber = '319-23-3782'
    )as e
	join ActiveCustomerLiveToRooms as c on c.idCustomer = e.idCustomer
    join Regions as d on d.idRegions=c.idRoom
    ;