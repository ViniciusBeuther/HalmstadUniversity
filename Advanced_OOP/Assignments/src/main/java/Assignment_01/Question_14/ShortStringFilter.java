package Assignment_01.Question_14;

public class ShortStringFilter implements Filter{
    @Override
    public boolean accept(String x){
        return x.length() <= 3;
    }
}