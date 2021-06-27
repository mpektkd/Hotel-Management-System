CREATE VIEW CustomerInfo AS
select 
		LastName,
        FirstName,
        BirthDate,
        Gender,
        Number,
        Email,
        SINNumber,
        SINDocument,
        SINIssueAuthority

 from Customer as a
join Phone as b on b.idCustomer=a.idCustomer
join Email as c on c.idCustomer=a.idCustomer
join SIN as d on d.idCustomer=a.idCustomer