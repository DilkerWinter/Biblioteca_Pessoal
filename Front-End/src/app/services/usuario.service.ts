import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map, Observable, tap } from 'rxjs';
import { Usuario } from '../model/Usuario';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {

  private apiUrl = "http://localhost:8000";

  constructor(private http:HttpClient, private authService: AuthService) { }

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

  buscaUsuarioLogado(): Observable<Usuario> {
    const urlBusca = `${this.apiUrl}/usuario`;
    
    const userId: number = Number(this.authService.getSessionToken());
    
    const usuarioData = {
      id: userId,
    };

    return this.http.post<any>(urlBusca, usuarioData);
  }

  editarUsuario(usuario: Usuario): Observable<any> {
    const urlAtualizar = `${this.apiUrl}/atualizar`;
  
    const usuarioData = {
      id: usuario.id,
      nome: usuario.nome,
      senha: usuario.senha
    };
  
    return this.http.put<any>(urlAtualizar, usuarioData);
  }
  
  nomeUsuarioJaExiste(nome: string): Observable<boolean> {
    const urlCheckUsername = `${this.apiUrl}/existente`;  
    
    const usuarioData = {
      nome: nome
    };
  
    return this.http.post<any>(urlCheckUsername, usuarioData).pipe(
      map(response => {
        return response.message === 'Nome de usuário já existe.';
      })
    );
  }
  
}
