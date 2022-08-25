import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
const baseUrl = 'http://localhost/Microexcel/php-app/';


@Injectable({
  providedIn: 'root'
})
export class ProductsService {

  constructor(private http:HttpClient) { }
  
  getAll(): Observable<any> {
    return this.http.get(baseUrl+'list.php');
  }

  get(id: any): Observable<any> {
    return this.http.get(baseUrl+'update.php?id='+id);
  }
  
  create(data: any): Observable<any> {
    return this.http.post(baseUrl+'create.php', data);
  }

  update(data: any): Observable<any> {
    return this.http.post(baseUrl+'update.php', data);
  }
}
