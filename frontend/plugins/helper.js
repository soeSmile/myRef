import * as Const from "../constants/constants";

export default ({app}, inject) => {
    inject('const', Const)
}