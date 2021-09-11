import React, {Component} from 'react';
import {Header, Message, Table} from 'semantic-ui-react';
import {API_BASE_URL} from './config'
import {FaTrashAlt, FaPencilAlt} from 'react-icons/fa'
import './employee.css'


class Employee extends Component {

    async getEmployees() {

        if (!this.state.employees) {
            try {
                this.setState({isLoading: true});
                const response = await fetch(API_BASE_URL + '/employees', {});
                const employeesList = await response.json();
                let employeesCheckboxes = {};
                for (let i = 0; i < employeesList.data.length; i++) {
                    employeesCheckboxes[employeesList.data[i].id] = false;
                }
                this.setState({
                    employees: employeesList.data,
                    isLoading: false,
                    checkboxes: employeesCheckboxes
                });
            } catch (err) {
                this.setState({isLoading: false});
                console.error(err);
            }
        }
    }


    constructor(props) {
        super(props);
        this.state = {
            employees: null,
            isLoading: null,
            disabled: true,
            checkboxes: {},
            isChecked: false,
        };
        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleChangeAll = this.handleChangeAll.bind(this);
    }

    handleInputChange(event) {
        let checkboxes = this.state.checkboxes;
        let index = parseInt(event.target.name);
        checkboxes[index] = event.target.checked;
        let disabledDeleteButton = !event.target.checked;
        if (disabledDeleteButton) {
            for (let key in checkboxes) {
                if (checkboxes[key]) {
                    disabledDeleteButton = false;
                    break;
                }
            }
        }
        this.setState({checkboxes: checkboxes, disabled: disabledDeleteButton});
    }

    handleChangeAll(event) {
        let checked = event.target.checked;
        let checkboxes = this.state.checkboxes;
        for (let key in checkboxes) {
            checkboxes[key] = checked;
        }
        this.setState({disabled: !checked, isChecked: checked});
    }

    componentDidMount(prevProps) {
        this.getEmployees();
    }

    deleteEmployees(employee) {
        if (window.confirm('Вы действительно хотите удалить сотрудника?')) {
            fetch(API_BASE_URL + '/employees/' + employee.id, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            });
            let employeesList = this.state.employees;
            delete employeesList[employeesList.findIndex((value, index, obj) => value.id === employee.id)];
            this.setState({employee: employeesList});
        }
    }

    age(date_of_birth) {
        let today = new Date();
        let birthDate = new Date(date_of_birth * 1000);
        let age = today.getFullYear() - birthDate.getFullYear();
        let month_dif = today.getMonth() - birthDate.getMonth();
        if ((month_dif < 0) || ((month_dif === 0) && (today.getDate() < birthDate.getDate()))) {
            age--;
        }
        return age;
    }

    weight_kg(weight) {
        let weight_kg = weight * 0.454;
        return weight_kg.toPrecision(3);
    }

    height_sm(height) {
        let height_сm;
        let arrayOfStrings = height.split("'");
        let feet = arrayOfStrings[0];
        if (arrayOfStrings[1] !== null) {
            let arrayOfStrings2 = arrayOfStrings[1];
            let inches = arrayOfStrings2.split('"');
            height_сm = feet * 30.48 + inches[0] * 2.54;
        } else {
            height_сm = feet * 30.48;
        }
        let meter = Math.floor(height_сm / 100);
        let centimeter = Math.floor(height_сm - meter * 100);

        return meter + "м " + centimeter + "см";
    }

    render() {

        return (
            <div>
                <Header as="h1">Таблица пользователей</Header>
                {this.state.isLoading && <Message info header="Loading players..."/>}
                {this.state.employees &&
                <div className="tbl">
                    <Table>
                        <thead>
                        <tr>
                            <th>
                                <label className="container">
                                    <input
                                        name="All"
                                        type="checkbox"
                                        checked={this.state.isChecked}
                                        onChange={this.handleChangeAll}/>
                                    <span className="checkmark"></span>
                                </label>
                            </th>
                            <th>№</th>
                            <th>ФИО</th>
                            <th>Возвраст (лет)</th>
                            <th>Рост</th>
                            <th>Вес</th>
                            <th>Зарплата</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>


                        {this.state.employees.map(
                            employee =>
                                <tr id={employee.id} key={employee.id} className="tableSting">
                                    <td>
                                        <label className="container">
                                            <input
                                                name={employee.id}
                                                type="checkbox"
                                                checked={this.state.checkboxes[employee.id]}
                                                onChange={this.handleInputChange}
                                            />
                                            <span className="checkmark"></span>
                                        </label>
                                    </td>
                                    <td>{employee.id}</td>
                                    <td>{employee.first_name + " " + employee.last_name}</td>
                                    <td>{this.age(employee.date_of_birth)}</td>
                                    <td>{this.height_sm(employee.height)}</td>
                                    <td>{this.weight_kg(employee.weight) + "кг"}</td>
                                    <td>{"$" + employee.salary}</td>

                                    <td>
                                        <button className="buttonIcon"><FaPencilAlt/></button>
                                    </td>
                                    <td>
                                        <button className="buttonIcon" onClick={() => this.deleteEmployees(employee)}>
                                            <FaTrashAlt/></button>
                                    </td>
                                </tr>
                        )}

                        </tbody>
                    </Table>
                </div>
                }
                <button disabled={this.state.disabled} className="buttonDelete"> Удалить выбранные</button>
            </div>
        );
    }
}

export default Employee;