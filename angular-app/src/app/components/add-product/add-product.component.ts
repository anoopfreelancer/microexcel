import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ProductsService } from 'src/app/services/products.service';

@Component({
  selector: 'app-add-product',
  templateUrl: './add-product.component.html',
  styleUrls: ['./add-product.component.css']
})
export class AddProductComponent implements OnInit {
  product = {
    name: '',
    slug: '',
    description: '',
    category: ''
  };
  submitted = false;
  filedata:any;

  constructor(private productService: ProductsService) { }

  ngOnInit(): void {  }

  fileEvent(e:any){
      this.filedata = e.target.files[0];
  }

  onSubmitform(f: NgForm) {
    
    var form = document.getElementsByClassName('validation')[0] as HTMLFormElement;    
    form.classList.add('was-validated');
    
    var myFormData = new FormData();
    
    myFormData.append('image', this.filedata);
    myFormData.append('name', this.product.name);
    myFormData.append('category', this.product.category);
    myFormData.append('slug', this.product.slug);
    myFormData.append('description', this.product.description);

    this.productService.create(myFormData)
      .subscribe(response => {
        if(response.status !== 'required'){
          this.submitted = true;
        }
      }, error => { 
        console.log('error', error)
      });
  }
}
