import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, tap } from 'rxjs';
import { Usuario } from '../model/Usuario';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {

  private apiUrl = "http://localhost:8000";

  constructor(private http:HttpClient) { }

  registrar(usuario: Usuario): Observable<any> {
    const urlRegistrar = `${this.apiUrl}/registrar`;

    const usuarioData = {
      nome: usuario.nome,
      senha: usuario.senha
    }

    return this.http.post<any>(urlRegistrar, usuarioData);
  }

  login(nome: string, senha: string): Observable<any> {
    const urlLogin = `${this.apiUrl}/login`;
  
    const usuarioData = {
      nome: nome,
      senha: senha
    };
  
    return this.http.post<any>(urlLogin, usuarioData).pipe(
      tap(response => {
        if (response && response.user_id) {
          localStorage.setItem('session_token', response.user_id.toString());
        }
      })
    );
  }
  
}
