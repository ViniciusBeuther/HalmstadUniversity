package Assignment_02.Question_08;

public class Main {
    public static void main(String[] args){
        // Initial list of words for testing class
        String[] words = {"Duck", "Bear", "Fish", "OOP", "AAA", "Bee"};

        // Instantiate our filter class, which is based on the Filter Interface
        ShortStringFilter shortFilter = new ShortStringFilter();

        // Call the method to filter the words with size <= 3
        String[] acceptedWords = shortFilter.filter(words);

        System.out.println("==== Words with length <= 3 ====");

        // Loop list to print words
        for(String word : acceptedWords){
            System.out.println(word);
        }
    }

}
