import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Livro } from '../model/Livro';
import { Observable } from 'rxjs';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root'
})
export class LivroService {

  private apiUrl = "http://localhost:8000/livro"; 

  constructor(private http: HttpClient, private authService: AuthService) {}

  adicionarLivro(livro: Livro): Observable<any> {
    const livroData = {
      titulo: livro.titulo,
      autor: livro.autor,
      usuario_id: livro.usuarioId,  
      urlimagem: livro.urlimagem,
      comentario: livro.comentario,
      nota: livro.nota,
      status: livro.status
    };

    const urlComRegistro = `${this.apiUrl}/registrar`;

    return this.http.post(urlComRegistro, livroData);
  }

  buscarTodosLivrosUsuario(): Observable<Livro[]> {
    const userId: number = Number(this.authService.getSessionToken());
    const payload = { usuario_id: userId };

    return this.http.post<Livro[]>(this.apiUrl, payload);
  }

  editarLivro(livro: Livro): Observable<any> {
    const livroData = {
      id: livro.id,  
      titulo: livro.titulo,
      autor: livro.autor,
      urlimagem: livro.urlimagem,
      comentario: livro.comentario,
      nota: livro.nota,
      status: livro.status
    };

    const urlAtualizar = `${this.apiUrl}/atualizar`;

    return this.http.put(urlAtualizar, livroData);
  }

  deletarLivro(id?: number): Observable<any> {
    const urlDeletar = `${this.apiUrl}/deletar`;

    return this.http.delete(urlDeletar, { 
      body: { id } 
    });
  }
}
