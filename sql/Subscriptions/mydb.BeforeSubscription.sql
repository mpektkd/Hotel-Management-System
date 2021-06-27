DELIMITER $$

CREATE TRIGGER before_subscription_insert
BEFORE INSERT
ON SubscriptionToServices
FOR EACH ROW
BEGIN
	
    declare days int;
	declare cost int;
    
    set days = (select datediff(LeavingDatetime, ArrivalDatetime)
				from ActiveCustomerLiveToRooms
					where BraceletId = new.BraceletId
    );
    
    set cost = (select CostPerDay
				from SubscribedServices
					where idSubscribed = new.idServices
    );
    
	
	set new.CostAmount = days*cost;
    
    update ActiveCustomerLiveToRooms
		set TotalBill = TotalBill + new.CostAmount
			where BraceletId=new.BraceletId;
    
    set new.SubscriptionDatetime = (
								select ArrivalDatetime 
								from ActiveCustomerLiveToRooms
									where BraceletId=new.BraceletId);
            
END$$

DELIMITER ;




