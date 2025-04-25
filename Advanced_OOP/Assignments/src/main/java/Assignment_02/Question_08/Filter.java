package Assignment_02.Question_08;

public abstract class Filter {
    // hook method
    public abstract boolean accept(String x);

    // main method for filtering
    public String[] filter(String[] input){
        int counter = 0;

        // loop the word list and count how many are accepted
        for(String s : input){
            if(accept(s))
                counter++;
        }

        // initialize return array
        String[] result = new String[counter];
        int idx = 0;

        // loop again and if the word is accepted add to return array, this is to make sure that
        // the return array have just the necessary size. result = new String[number of words]
        for(String s : input){
            if(accept(s)){
                result[idx] = s;
                idx++;
            }
        }

        // return array with accepted words
        return result;
    }
}
