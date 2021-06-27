DELIMITER $$

CREATE TRIGGER before_charges_insert
BEFORE INSERT
ON ServiceCharge 
FOR EACH ROW
BEGIN

	IF (
		select 
			a.idServices 
		From Services as a 
        join ServiceMenu as b on b.idServices=a.idServices
			where b.idServiceMenu=new.idServiceMenu
		) in (1,2,3) then
	begin
	SET new.CostAmount= new.CostAmount + 
		(
			select CostPerUnit from ServiceMenu
				where idServiceMenu=new.idServiceMenu
        ) * new.Quantity
    ;
    end;
    END IF;
            
END$$

DELIMITER ;


