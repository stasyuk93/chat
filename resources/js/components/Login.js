import React, {Component} from "react";
import axios from 'axios';
import cookie from 'react-cookies';

class Login extends Component{
    constructor(props){
        super(props);
        this.state = {
            name:'',
            password:''
        };

        this.login = () => {
            axios.post('/api/login',{
                name: this.state.name,
                password: this.state.password,
            }).then((response)=>{
                const token = response.data.token;
                cookie.save('token',token,{path:'chat.loc/react'});
                props.connect(token);
            }).catch((e) => {
                console.log(e);
            })
        };

        this.onChangeName = (e) => {
            this.setState({
                name: e.target.value
            })
        };

        this.onChangePassword = (e) => {
            this.setState({
                password: e.target.value
            })
        }
    }

    render(){
        return (
            <div className='col-md-8'>
                <div className="card">
                    <div className="card-header">Login</div>
                    <div className="card-body">
                        <div className="form-group row">
                            <div className="col-md-6">
                                <input onChange={this.onChangeName}
                                    id="name" type="text"
                                    className="form-control"
                                    name="name"
                                    required
                                    autoComplete="name" autoFocus/>
                            </div>
                        </div>
                        <div className="form-group row">
                            <div className="col-md-6">
                                <input onChange={this.onChangePassword}
                                    id="password" type="password"
                                    className="form-control"
                                    name="password"
                                    required/>
                            </div>
                        </div>
                        <div className="form-group row mb-0">
                            <div className="col-md-8 offset-md-4">
                                <button onClick={this.login} type="button" className="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Login;
