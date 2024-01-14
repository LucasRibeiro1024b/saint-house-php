class Paciente {
    constructor () {
        this.id = document.getElementById("pId");
        this.nome = document.getElementById("pNome");
        this.sexo = document.querySelector('input[name="sexo"]:checked');
        this.dt_nascimento = document.getElementById("dt_nascimento");
    }

    getJSON(){
        return {
            "id": null,
            "nome": null,
            "sexo": null,
            "dt_nascimento": null
        };
    }
};

// let paciente = new Paciente();
// console.log(paciente);

let pForm = document.getElementById("cadPaciente");
pForm.addEventListener();
