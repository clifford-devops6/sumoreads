export function useTruncate(value:string, length:number){
    if (value.length > length) {
        return value.substring(0, length) + "...";
    } else {
        return value;
    }
}
