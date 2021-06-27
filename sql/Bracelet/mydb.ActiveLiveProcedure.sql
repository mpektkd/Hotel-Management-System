DELIMITER $$
CREATE PROCEDURE ActiveLive(
	cid1 int,
    cid2 int,
    arrival datetime,
    flag1 int,
    flag2 int,
    flag3 int,
    r int
)
DETERMINISTIC
BEGIN
	
    DECLARE n, i, id, rid, m, prev_m int;
    
    set rid = r;
	
-- 	select count(*) 
--     from ActiveCustomerLiveToRooms
-- 		into m;
        
	select 41 into m;
	set prev_m = m;
    
	SELECT COUNT(*) 
    FROM Customer
		where idCustomer between cid1 and cid2
		INTO n;
        
	SET i=0;
	select 0 into @counter;
	WHILE i<n DO 
		set m = m + 1;
        
		SELECT idCustomer 
        FROM Customer 
			where idCustomer between cid1 and cid2
            LIMIT i,1 into id;
        
        # Insert Values to Active
        insert into ActiveCustomerLiveToRooms (BraceletId, idCustomer, idRoom, ArrivalDatetime, LeavingDatetime,TotalBill)
        values(m, id, rid, arrival, date_add(arrival, interval 7 day),0.00);
        
        
        # Insert Values to Subscription
        
        if flag1=1 then
        begin
			insert into SubscriptionToServices (BraceletId, idServices)
			values(m, 4);
        end;
        end if;
        
        if flag2=1 then
        begin
			insert into SubscriptionToServices (BraceletId, idServices)
			values(m, 5);
        end;
        end if;
        
        if flag3=1 then
        begin
			insert into SubscriptionToServices (BraceletId, idServices)
			values(m, 6);
        end;
        end if;
        
        
        set rid = rid + 2;
        set i = i + 1;
        set @counter = @counter + 1;
        
	end while;
    
    call PassEntries(prev_m+1, m,0);

END$$
DELIMITER ;

call ActiveLive (1, 30, '2021-03-15 12:35:04', 0, 1, 1, 40);


