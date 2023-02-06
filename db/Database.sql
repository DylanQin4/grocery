-- creating member/admin table --

CREATE TABLE Member (
    memberID INT AUTO_INCREMENT,
    memberCode VARCHAR(10),
    name VARCHAR(30) NOT NULL,
    firstName VARCHAR(30) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    isAdmin INT(1) NOT NULL,
    PRIMARY KEY(memberID)
);
-- inserting admin account --
INSERT INTO Member VALUES(
    1,
    "123",
    "su_member",
    "admin",
    "+261 32 55 063 38",
    "admin123@gmail.com",
    "123",
    1
);
INSERT INTO Member VALUES(
    2,
    "421",
    "Madame",
    "Amboara",
    "+261 34 93 159 28",
    "amboara@gmail.com",
    "123",
    0
);
INSERT INTO Member VALUES(
    3,
    "007",
    "Monsieur",
    "Steve",
    "+261 39 00 789 22",
    "steve@gmail.com",
    "123",
    0
);

-- creating client table --

CREATE TABLE Client (
    clientID INT AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    firstName VARCHAR(30) NOT NULL,
    contact VARCHAR(20) DEFAULT "Pas de contact",
    PRIMARY KEY(clientID)
);
-- inserting a random client --
INSERT INTO Client VALUES(1, "Rakoto", "Jean", "0349315928");

-- creating category table --

CREATE TABLE Category (
    categoryID INT AUTO_INCREMENT,
    name VARCHAR(30),
    isVisible VARCHAR(3) DEFAULT "YES",
    PRIMARY KEY(categoryID)
);
-- inserting some categories --
INSERT INTO Category VALUES(NULL, "Baby", "YES");
INSERT INTO Category VALUES(NULL, "PPN", "YES");
INSERT INTO Category VALUES(NULL, "Cuisine", "YES");

-- creating product table --

CREATE TABLE Product (
    productID INT AUTO_INCREMENT,
    categoryID INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    purchasingPrice DOUBLE DEFAULT 0,
    sellingPrice DOUBLE DEFAULT 0,
    stock INT,
    photo VARCHAR(50),
    isVisible VARCHAR(3) DEFAULT "YES",
    PRIMARY KEY(productID),
    FOREIGN KEY(categoryID) REFERENCES Category(categoryID)
);
-- inserting some products --
INSERT INTO Product VALUES(NULL, 1, "Couche", 600, 800, 30, "couche.png", "YES");
INSERT INTO Product VALUES(NULL, 1, "Biberon", 18000, 18500, 5, "biberon.png", "YES");
INSERT INTO Product VALUES(NULL, 2, "Menaka", 5500, 5800, 4, "menaka.png", "YES");
INSERT INTO Product VALUES(NULL, 2, "Labozia", 300, 500, 7, "bougie.png", "YES");
INSERT INTO Product VALUES(NULL, 2, "Sira", 100, 200, 14, "sira.png", "YES");
INSERT INTO Product VALUES(NULL, 3, "Cuillere", 1250, 1500, 10, "sotro.png", "YES");
INSERT INTO Product VALUES(NULL, 3, "Couteau", 2800, 3000, 5, "couteau.png", "YES");
INSERT INTO Product VALUES(NULL, 3, "Marmite", 24500, 25000, 3, "marmite.png", "YES");

-- creating payement method table --

CREATE TABLE PaymentMethod (
    paymentMethodID INT AUTO_INCREMENT,
    method VARCHAR(15),
    PRIMARY KEY(paymentMethodID)
);
-- inserting some payment method --
INSERT INTO PaymentMethod VALUES(NULL, "Cash");
INSERT INTO PaymentMethod VALUES(NULL, "Mobile money");

-- creating invoice table --

CREATE TABLE Invoice (
    invoiceID INT AUTO_INCREMENT,
    clientID INT NOT NULL,
    date DATE,
    isVisible VARCHAR(3) DEFAULT "YES",
    PRIMARY KEY(invoiceID),
    FOREIGN KEY(clientID) REFERENCES Client(clientID)
);

-- creating command table --

CREATE TABLE Command (
    commandID INT AUTO_INCREMENT,
    invoiceID INT NOT NULL,
    productID INT NOT NULL,
    productQuantity INT NOT NULL,
    memberID INT NOT NULL, -- the member who took care of the order  --
    paymentMethodID INT NOT NULL,

    -- in case, by mobile money --
    clientContact VARCHAR(20),
    -- |||||||||||||||||||||||| --

    PRIMARY KEY(commandID),
    FOREIGN KEY(invoiceID) REFERENCES Invoice(invoiceID),
    FOREIGN KEY(productID) REFERENCES Product(productID),
    FOREIGN KEY(memberID) REFERENCES Member(memberID),
    FOREIGN KEY(paymentMethodID) REFERENCES PaymentMethod(paymentMethodID)
);