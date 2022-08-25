import { Component, OnInit } from '@angular/core';
import { ProductsService } from 'src/app/services/products.service';

@Component({
  selector: 'app-list-product',
  templateUrl: './list-product.component.html',
  styleUrls: ['./list-product.component.css']
})

export class ListProductComponent implements OnInit {

  products: any;
  records = true;
  
  constructor(private productService: ProductsService) { }

  ngOnInit(): void {
    this.retrieveProducts();
  }

  retrieveProducts(): void {
    this.productService.getAll()
      .subscribe(
        response => {
          this.products = response.data;
          if(response.status == 'empty'){
            this.records = false;
          }
        },
        error => {
          console.log(error);
        });
  }

}
