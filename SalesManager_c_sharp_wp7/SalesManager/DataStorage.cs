/*
 * Data storage layer
 */

using System;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Shapes;

using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Data.Linq;
using System.Data.Linq.Mapping;
using System.ComponentModel;

namespace SalesManager
{
    [Table]
    public class Customer : INotifyPropertyChanged, INotifyPropertyChanging
    {
        [Column(IsPrimaryKey = true, IsDbGenerated = true, AutoSync = AutoSync.OnInsert)]
        public int CustomerID { get; set; }

        private string nameValue;

        [Column]
        public string Name
        {
            get
            {
                return nameValue;
            }
            set
            {
                NotifyPropertyChanging("Name");
                nameValue = value;
                NotifyPropertyChanged("Name");
            }
        }

        private string addressValue;
        [Column]
        public string Address
        {
            get
            {
                return addressValue;
            }
            set
            {
                NotifyPropertyChanging("Address");
                addressValue = value;
                NotifyPropertyChanged("Address");
            }
        }

        private string BankDetailsValue;
        [Column]
        public string BankDetails
        {
            get
            {
                return BankDetailsValue;
            }
            set
            {
                NotifyPropertyChanging("BankDetails");
                BankDetailsValue = value;
                NotifyPropertyChanged("BankDetails");
            }
        }

        private EntitySet<Order> orders = new EntitySet<Order>();

        [Association(Storage = "orders", ThisKey = "CustomerID", OtherKey = "OrderCustomerID")]
        public EntitySet<Order> Orders
        {
            get
            {
                return orders;
            }
            set
            {
                orders = value;
            }
        }

        private void NotifyPropertyChanged(string propertyName)
        {
            if (PropertyChanged != null)
            {
                PropertyChanged(this, new PropertyChangedEventArgs(propertyName));
            }
        }

        private void NotifyPropertyChanging(string propertyName)
        {
            if (PropertyChanging != null)
            {
                PropertyChanging(this, new PropertyChangingEventArgs(propertyName));
            }
        }

        public event PropertyChangedEventHandler PropertyChanged;
        public event PropertyChangingEventHandler PropertyChanging;
    }

    [Table]
    public class Product : INotifyPropertyChanged, INotifyPropertyChanging
    {

        [Column(IsPrimaryKey = true, IsDbGenerated = true, AutoSync = AutoSync.OnInsert)]
        public int ProductID { get; set; }

        private string nameValue;

        [Column]
        public string Name
        {
            get
            {
                return nameValue;
            }
            set
            {
                NotifyPropertyChanging("Name");
                nameValue = value;
                NotifyPropertyChanged("Name");
            }
        }

        private string supplierValue;

        [Column]
        public string Supplier
        {
            get
            {
                return supplierValue;
            }
            set
            {
                NotifyPropertyChanging("Supplier");
                supplierValue = value;
                NotifyPropertyChanged("Supplier");
            }
        }

        private int priceValue;
        [Column]
        public int Price
        {
            get
            {
                return priceValue;
            }
            set
            {
                NotifyPropertyChanging("Price");
                priceValue = value;
                NotifyPropertyChanged("Price");
            }
        }

        private void NotifyPropertyChanged(string propertyName)
        {
            if (PropertyChanged != null)
            {
                PropertyChanged(this, new PropertyChangedEventArgs(propertyName));
            }
        }

        private void NotifyPropertyChanging(string propertyName)
        {
            if (PropertyChanging != null)
            {
                PropertyChanging(this, new PropertyChangingEventArgs(propertyName));
            }
        }

        public event PropertyChangedEventHandler PropertyChanged;
        public event PropertyChangingEventHandler PropertyChanging;
    }

    [Table]
    public class Order : INotifyPropertyChanged, INotifyPropertyChanging
    {

        [Column(IsPrimaryKey = true, IsDbGenerated = true, AutoSync = AutoSync.OnInsert)]
        public int OrderID;

        private EntitySet<OrderItem> orderItems = new EntitySet<OrderItem>();

        [Association(Storage = "orderItems", ThisKey = "OrderID", OtherKey = "orderItemOrderID")]
        public EntitySet<OrderItem> OrderItems
        {
            get
            {
                return orderItems;
            }
            set
            {
                orderItems = value;
            }
        }


        private string orderDescription;

        [Column]
        public string OrderDescription
        {
            get
            {
                return orderDescription;
            }
            set
            {
                NotifyPropertyChanging("OrderDescription");
                orderDescription = value;
                NotifyPropertyChanged("OrderDescription");
            }
        }

        private DateTime orderDate;

        [Column]
        public DateTime OrderDate
        {
            get
            {
                return orderDate;
            }
            set
            {
                NotifyPropertyChanging("OrderDate");
                orderDate = value;
                NotifyPropertyChanged("OrderDate");
            }
        }

        [Column]
        public int OrderCustomerID;

        private EntityRef<Customer> orderCustomer = new EntityRef<Customer>();

        [Association(IsForeignKey = true, Storage = "orderCustomer", ThisKey = "OrderCustomerID")]
        public Customer OrderCustomer
        {
            get
            {
                return orderCustomer.Entity;
            }
            set
            {
                NotifyPropertyChanging("OrderCustomer");
                orderCustomer.Entity = value;
                NotifyPropertyChanged("OrderCustomer");
                if (value != null)
                    OrderCustomerID = value.CustomerID;
            }
        }

        private void NotifyPropertyChanged(string propertyName)
        {
            if (PropertyChanged != null)
            {
                PropertyChanged(this, new PropertyChangedEventArgs(propertyName));
            }
        }

        private void NotifyPropertyChanging(string propertyName)
        {
            if (PropertyChanging != null)
            {
                PropertyChanging(this, new PropertyChangingEventArgs(propertyName));
            }
        }

        public event PropertyChangedEventHandler PropertyChanged;
        public event PropertyChangingEventHandler PropertyChanging;

    }

    [Table]
    public class OrderItem : INotifyPropertyChanged, INotifyPropertyChanging
    {

        [Column(IsPrimaryKey = true, IsDbGenerated = true, AutoSync = AutoSync.OnInsert)]
        public int OrderItemID;


        [Column]
        private int orderItemOrderID;

        private EntityRef<Order> order = new EntityRef<Order>();

        [Association(IsForeignKey = true, Storage = "order", ThisKey = "orderItemOrderID")]
        public Order ItemOrder
        {
            get
            {
                return order.Entity;
            }
            set
            {
                NotifyPropertyChanging("ItemOrder");
                order.Entity = value;
                NotifyPropertyChanged("ItemOrder");
                if (value != null)
                    orderItemOrderID = value.OrderID;
            }
        }

        [Column]
        private int orderItemProductID;

        private EntityRef<Product> orderItemProduct = new EntityRef<Product>();

        [Association(IsForeignKey = true, Storage = "orderItemProduct", ThisKey = "orderItemProductID")]
        public Product OrderItemProduct
        {
            get
            {
                return orderItemProduct.Entity;
            }
            set
            {
                NotifyPropertyChanging("OrderItemProduct");
                orderItemProduct.Entity = value;
                NotifyPropertyChanged("OrderItemProduct");
                if (value != null)
                    orderItemProductID = value.ProductID;
            }
        }

        private int quantityValue;
        [Column]
        public int Quantity
        {
            get
            {
                return quantityValue;
            }
            set
            {
                NotifyPropertyChanging("Quantity");
                quantityValue = value;
                NotifyPropertyChanged("Quantity");
            }
        }

        private void NotifyPropertyChanged(string propertyName)
        {
            if (PropertyChanged != null)
            {
                PropertyChanged(this, new PropertyChangedEventArgs(propertyName));
            }
        }

        private void NotifyPropertyChanging(string propertyName)
        {
            if (PropertyChanging != null)
            {
                PropertyChanging(this, new PropertyChangingEventArgs(propertyName));
            }
        }

        public event PropertyChangedEventHandler PropertyChanged;
        public event PropertyChangingEventHandler PropertyChanging;
    }

    public class SalesDB : DataContext
    {
        public string Name { get; set; }

        public Table<Customer> CustomerTable;

        public Table<Product> ProductTable;

        public Table<Order> OrderTable;

        public Table<OrderItem> OrderItemTable;

        public SalesDB(string connection)
            : base(connection)
        {
        }

        /// <summary>
        /// Prepare test data.
        /// </summary>
        /// <param name="connection"></param>
        public static void MakeTestDB(string connection)
        {
            string[] firstNames = new string[] { "Anna", "Bogdan", "Jan", "Stefan", "Tomek", "Tadek" };
            string[] lastsNames = new string[] { "Jarosz", "Kowalski", "Nowak", "Nowak", "Wiejski", "Werych" };

            string[] productNames = new string[] { "Mobile device", "Computer", "Accessories", "Software" };
            string[] companyNames = new string[] { "Firma Sp. z o.o.", "Company, Inc.", "Cool products Ltd" };

            using (SalesDB newDB = new SalesDB(connection))
            {

                if (newDB.DatabaseExists())
                {
                    newDB.DeleteDatabase();
                }

                newDB.CreateDatabase();

                foreach (string lastName in lastsNames)
                {
                    foreach (string firstname in firstNames)
                    {
                        // build default details
                        string name = firstname + " " + lastName;
                        string address = name + "'s address";
                        string bank = name + "'s bank";
                        Customer newCustomer = new Customer();
                        newCustomer.Name = name;
                        newCustomer.Address = address;
                        newCustomer.BankDetails = bank;
                        newDB.CustomerTable.InsertOnSubmit(newCustomer);
                        newDB.SubmitChanges();
                    }
                }

                Random random = new Random(1);

                foreach (string companyName in companyNames)
                {
                    foreach (string productName in productNames)
                    {
                        Product newProduct = new Product();
                        newProduct.Name = productName;
                        newProduct.Supplier = companyName;
                        newProduct.Price = random.Next(100, 20000);
                        newDB.ProductTable.InsertOnSubmit(newProduct);
                        newDB.SubmitChanges();
                    }
                }

                // Create random orders for our customers

                // Get products
                var allProducts = from Product product
                                  in newDB.ProductTable
                                  select product;

                List<Product> productList = allProducts.ToList<Product>();

                var customers = from Customer customer
                                in newDB.CustomerTable
                                select customer;

                // Startdate for randomly produced orders - always the same
                DateTime startDate = new DateTime(2012, 3, 27);

                foreach (Customer c in customers)
                {
                    int noOfOrders = random.Next(0, 11);
                    for (int i = 0; i < noOfOrders; i++)
                    {
                        Order newOrder = new Order();
                        newOrder.OrderDescription = c.Name + " order " + i.ToString();
                        newOrder.OrderCustomer = c;
                        newOrder.OrderDate = startDate.AddDays(-random.Next(150));
                        int noOfProducts = random.Next(1, 20);
                        for (int j = 0; j < noOfProducts; j++)
                        {
                            OrderItem detail = new OrderItem();
                            detail.ItemOrder = newOrder;
                            // Pick a random product
                            Product p = productList[random.Next(0, productList.Count)];
                            detail.OrderItemProduct = p;
                            detail.Quantity = random.Next(1, 20);
                            newDB.OrderItemTable.InsertOnSubmit(detail);
                            newOrder.OrderItems.Add(detail);
                        }

                        c.Orders.Add(newOrder);

                        newDB.OrderTable.InsertOnSubmit(newOrder);
                        newDB.SubmitChanges();
                    }
                }
            }
        }
    }
}
