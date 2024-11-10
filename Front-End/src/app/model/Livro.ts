export class Livro {
    private _id?: number;  
    private _titulo: string;
    private _autor: string;
    private _urlimagem: string;  
    private _nota: number;
    private _status: string;
    private _comentario: string;
    private _usuarioId: number;
  
    constructor(
      titulo: string,
      autor: string,
      urlimagem: string,  
      nota: number,
      status: string,
      comentario: string,
      usuarioId: number,
      id?: number  
    ) {
      this._id = id;
      this._titulo = titulo;
      this._autor = autor;
      this._urlimagem = urlimagem;
      this._nota = nota;
      this._status = status;
      this._comentario = comentario;
      this._usuarioId = usuarioId;
    }
  
    get id(): number | undefined {
      return this._id;
    }
  
    set id(id: number | undefined) {
      this._id = id;
    }
  
    get titulo(): string {
      return this._titulo;
    }
  
    set titulo(titulo: string) {
      this._titulo = titulo;
    }
  
    get autor(): string {
      return this._autor;
    }
  
    set autor(autor: string) {
      this._autor = autor;
    }
  
    get urlimagem(): string {  
      return this._urlimagem;
    }
  
    set urlimagem(urlimagem: string) {  
      this._urlimagem = urlimagem;
    }
  
    get nota(): number {
      return this._nota;
    }
  
    set nota(nota: number) {
      this._nota = nota;
    }
  
    get status(): string {
      return this._status;
    }
  
    set status(status: string) {
      this._status = status;
    }
  
    get comentario(): string {
      return this._comentario;
    }
  
    set comentario(comentario: string) {
      this._comentario = comentario;
    }
  
    get usuarioId(): number {
      return this._usuarioId;
    }
  
    set usuarioId(usuarioId: number) {
      this._usuarioId = usuarioId;
    }
  }
  