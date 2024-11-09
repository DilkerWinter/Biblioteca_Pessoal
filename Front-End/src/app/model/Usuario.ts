export class Usuario {
    private _id?: number;
    private _nome: string;
    private _senha: string;
  
    constructor(nome: string, senha: string, id?: number) {
      this._id = id;
      this._nome = nome;
      this._senha = senha;
    }
  
    get id(): number | undefined {
      return this._id;
    }
  
    set id(id: number | undefined) {
      this._id = id;
    }
  
    get nome(): string {
      return this._nome;
    }
  
    set nome(nome: string) {
      this._nome = nome;
    }
  
    get senha(): string {
      return this._senha;
    }
  
    set senha(senha: string) {
      this._senha = senha;
    }
    
  }
  
  