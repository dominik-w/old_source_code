﻿#pragma checksum "C:\Users\Dominik\Documents\Visual Studio 2010\Projects\SalesManager\SalesManager\ProductDetailPage.xaml" "{406ea660-64cf-4c82-b6f0-42d48172a799}" "81E71ED0281C74CD00D133914172AC1D"
//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated by a tool.
//     Runtime Version:4.0.30319.488
//
//     Changes to this file may cause incorrect behavior and will be lost if
//     the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

using Microsoft.Phone.Controls;
using System;
using System.Windows;
using System.Windows.Automation;
using System.Windows.Automation.Peers;
using System.Windows.Automation.Provider;
using System.Windows.Controls;
using System.Windows.Controls.Primitives;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Interop;
using System.Windows.Markup;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Media.Imaging;
using System.Windows.Resources;
using System.Windows.Shapes;
using System.Windows.Threading;


namespace SalesManager {
    
    
    public partial class ProductDetailPage : Microsoft.Phone.Controls.PhoneApplicationPage {
        
        internal System.Windows.Controls.Grid LayoutRoot;
        
        internal System.Windows.Controls.StackPanel TitlePanel;
        
        internal System.Windows.Controls.TextBlock ApplicationTitle;
        
        internal System.Windows.Controls.TextBlock PageTitle;
        
        internal System.Windows.Controls.Grid ContentPanel;
        
        internal System.Windows.Controls.Grid productDisplayGrid;
        
        internal System.Windows.Controls.TextBlock nameTextBlock;
        
        internal System.Windows.Controls.TextBox nameTextBox;
        
        internal System.Windows.Controls.TextBlock supplierTextBlock;
        
        internal System.Windows.Controls.TextBox supplierTextBox;
        
        internal System.Windows.Controls.TextBlock priceTextBlock;
        
        internal System.Windows.Controls.TextBox priceTextBox;
        
        internal System.Windows.Controls.TextBlock idTextBlock;
        
        internal System.Windows.Controls.TextBox idTextBox;
        
        internal System.Windows.Controls.Button saveButton;
        
        internal System.Windows.Controls.Button cancelButton;
        
        private bool _contentLoaded;
        
        /// <summary>
        /// InitializeComponent
        /// </summary>
        [System.Diagnostics.DebuggerNonUserCodeAttribute()]
        public void InitializeComponent() {
            if (_contentLoaded) {
                return;
            }
            _contentLoaded = true;
            System.Windows.Application.LoadComponent(this, new System.Uri("/SalesManager;component/ProductDetailPage.xaml", System.UriKind.Relative));
            this.LayoutRoot = ((System.Windows.Controls.Grid)(this.FindName("LayoutRoot")));
            this.TitlePanel = ((System.Windows.Controls.StackPanel)(this.FindName("TitlePanel")));
            this.ApplicationTitle = ((System.Windows.Controls.TextBlock)(this.FindName("ApplicationTitle")));
            this.PageTitle = ((System.Windows.Controls.TextBlock)(this.FindName("PageTitle")));
            this.ContentPanel = ((System.Windows.Controls.Grid)(this.FindName("ContentPanel")));
            this.productDisplayGrid = ((System.Windows.Controls.Grid)(this.FindName("productDisplayGrid")));
            this.nameTextBlock = ((System.Windows.Controls.TextBlock)(this.FindName("nameTextBlock")));
            this.nameTextBox = ((System.Windows.Controls.TextBox)(this.FindName("nameTextBox")));
            this.supplierTextBlock = ((System.Windows.Controls.TextBlock)(this.FindName("supplierTextBlock")));
            this.supplierTextBox = ((System.Windows.Controls.TextBox)(this.FindName("supplierTextBox")));
            this.priceTextBlock = ((System.Windows.Controls.TextBlock)(this.FindName("priceTextBlock")));
            this.priceTextBox = ((System.Windows.Controls.TextBox)(this.FindName("priceTextBox")));
            this.idTextBlock = ((System.Windows.Controls.TextBlock)(this.FindName("idTextBlock")));
            this.idTextBox = ((System.Windows.Controls.TextBox)(this.FindName("idTextBox")));
            this.saveButton = ((System.Windows.Controls.Button)(this.FindName("saveButton")));
            this.cancelButton = ((System.Windows.Controls.Button)(this.FindName("cancelButton")));
        }
    }
}

