import { Component, OnInit } from '@angular/core';
import { ProductsService } from 'src/app/services/products.service';
import { ActivatedRoute, Router } from '@angular/router';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-edit-product',
  templateUrl: './edit-product.component.html',
  styleUrls: ['./edit-product.component.css']
})
export class EditProductComponent implements OnInit {

  filedata: any;
  products = {
    id: '',
    name: '',
    image: '',
    slug: '',
    description: '',
    category: ''
  };
  submitted = false;
  productImage: any;

  constructor(
      private productService:ProductsService, 
      private route: ActivatedRoute,
      private router: Router
    ) { }

  ngOnInit(): void {
    this.getProduct(this.route.snapshot.paramMap.get('id'));
  }

  getProduct(id: any): void {
    this.productService.get(id)
      .subscribe(
        response => {
          this.products = response.data;
          this.productImage = 'http://localhost/Microexcel/php-app/upload/'+this.products.image;
        },
        error => {
          console.log(error);
        });
  }

  getFiles(e:any){
    this.filedata = e.target.files[0];
  }

  updateProduct(f: NgForm): void {
    
    var myFormData = new FormData();
    
    if(this.filedata) {
      myFormData.append('image', this.filedata);
    } 

    myFormData.append('id', this.products.id);
    myFormData.append('name', this.products.name);
    myFormData.append('category', this.products.category);
    myFormData.append('slug', this.products.slug);
    myFormData.append('description', this.products.description);

    this.productService.update(myFormData)
      .subscribe(
        response => {
          if(response.status !== 'required') {
            this.submitted = true;
          }
        },
        error => {
          console.log(error);
        });
  }

}
